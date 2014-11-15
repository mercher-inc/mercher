<?php

class IndexController extends Controller
{
    public function filters()
    {
        return array(
            'accessControl',
        );
    }

    public function accessRules()
    {
        return array(
            array(
                'deny',
                'actions' => array('support'),
                'users'   => array('?'),
            ),
        );
    }

    /**
     * Declares class-based actions.
     */
    public function actions()
    {
        return array(
            // captcha action renders the CAPTCHA image displayed on the contact page
            'captcha' => array(
                'class'     => 'CCaptchaAction',
                'backColor' => 0xFFFFFF,
            ),
            // page action renders "static" pages stored under 'protected/views/site/pages'
            // They can be accessed via: index.php?r=site/page&view=FileName
            'page'    => array(
                'class' => 'CViewAction',
            ),
        );
    }

    /**
     * This is the default 'index' action that is invoked
     * when an action is not explicitly requested by users.
     */
    public function actionIndex()
    {
        if (!Yii::app()->user->isGuest) {
            $user = User::model()->findByPk(Yii::app()->user->id);
            if (!$user) {
                Yii::app()->user->logout();
            } else {
                if ($user->fb_id != Yii::app()->facebook->sdk->getUser()) {
                    Yii::app()->user->logout();
                } else {
                    $this->redirect(Yii::app()->urlManager->createUrl('shops/index'));
                }
            }
        }
        if (
            (
                Yii::app()->request->getParam('code')
                or
                Yii::app()->request->getParam('signed_request')
            )
            and
            Yii::app()->facebook->sdk->getUser()
        ) {

            $identity = new UserIdentity();
            if ($identity->authenticate()) {
                Yii::app()->user->login($identity, 3600 * 24 * 7);
                $this->redirect(Yii::app()->urlManager->createUrl('shops/index'));
            } else {
                $this->render(
                    'index',
                    [
                        'errorCode'    => $identity->errorCode,
                        'errorMessage' => $identity->errorMessage,
                    ]
                );
                return;
            }
        }

        $pages = Yii::app()->db->createCommand()
            ->select('shop.fb_id')
            ->from(Shop::model()->tableName() . ' AS shop')
            ->join(User::model()->tableName() . ' AS user', '"user"."id" = "shop"."owner_id"')
            ->where("shop.is_active = TRUE")
            ->where(
                [
                    "in",
                    "user.fb_id",
                    [
                        '176375372441230', //EDM Madness
                        '628065013907401'  //Daria's HAIR Accessories. FB shop.
                    ]
                    /*
                    [
                        '100006973868538', //Mihail Les
                        '100005603078334', //Open User
                        '100001974932720', //Dmitry Les
                        '100003241004104', //Olesya Lesyonovna
                        '2500458', //Sam Pogosov
                        '10805126', //Yury Adamov
                    ]
                    */
                ]
            )
            ->limit(6)
            ->queryColumn();

        $this->render(
            'index',
            [
                'pages' => $pages
            ]
        );
    }

    /**
     * Logs out the current user and redirect to homepage.
     */
    public function actionLogout()
    {
        Yii::app()->user->logout();
        $this->redirect(Yii::app()->homeUrl);
    }

    /**
     * This is the action to handle external exceptions.
     */
    public function actionError()
    {
        if ($error = Yii::app()->errorHandler->error) {
            if (Yii::app()->request->isAjaxRequest) {
                echo $error['message'];
            } else {
                $this->render('error', $error);
            }
        }
    }

    /**
     * Displays the contact page
     */
    public function actionContact()
    {
        $model = new ContactForm;
        if (isset($_POST['ContactForm'])) {
            $model->attributes = $_POST['ContactForm'];
            if ($model->validate()) {
                try {
                    $mail       = new YiiMailMessage($model->subject, $model->body, 'text/html', 'utf-8');
                    $mail->to   = 'dmitry.les@mercher.net';
                    $mail->from = $model->email;
                    Yii::app()->mail->send($mail);
                } catch (Exception $e) {
                    D($e);
                }
                Yii::app()->user->setFlash(
                    'contact',
                    'Thank you for contacting us. We will respond to you as soon as possible.'
                );
                $this->refresh();
            }
        }
        $this->render('contact_temp', array('model' => $model));
    }

    /*
    public function actionTest()
    {
        $payRequest                               = new \PayPalComponent\Request\PayRequest();
        $payRequest->actionType                   = \PayPalComponent\Request\PayRequest::ACTION_TYPE_PAY_PRIMARY;
        $payRequest->memo                         = 'memo';
        $payRequest->returnUrl                    = $this->createAbsoluteUrl('/index/test');
        $payRequest->cancelUrl                    = $this->createAbsoluteUrl('/index/test');
        $payRequest->currencyCode                 = \PayPalComponent\CurrencyCode::CURRENCY_CODE_USD;
        $payRequest->requestEnvelope->detailLevel = "ReturnAll";

        $clientDetails             = Yii::createComponent(
            [
                'class'         => '\PayPalComponent\Field\ClientDetails',
                'applicationId' => 'Mercher DEV'
            ]
        );
        $payRequest->clientDetails = $clientDetails;

        $receiver = Yii::createComponent(
            [
                'class'       => '\PayPalComponent\Field\Receiver',
                'amount'      => 2.00,
                'email'       => 'dmitriy.s.les-facilitator@gmail.com',
                'paymentType' => 'SERVICE',
                'primary'     => true,
            ]
        );
        $payRequest->receiverList->addReceiver($receiver);

        $receiver = Yii::createComponent(
            [
                'class'       => '\PayPalComponent\Field\Receiver',
                'amount'      => .95,
                'email'       => 'seller1.test@mercher.net',
                'paymentType' => 'GOODS',
                'primary'     => false,
            ]
        );
        $payRequest->receiverList->addReceiver($receiver);

        $receiver = Yii::createComponent(
            [
                'class'       => '\PayPalComponent\Field\Receiver',
                'amount'      => .95,
                'email'       => 'seller2.test@mercher.net',
                'paymentType' => 'GOODS',
                'primary'     => false,
            ]
        );
        $payRequest->receiverList->addReceiver($receiver);

        D($payRequest->__toArray());

        if (!$response = $payRequest->submit()) {
            D($payRequest, 1);
        } else {
            if ($response instanceof \PayPalComponent\Response\PayResponse) {
                D($response);
                echo CHtml::link(
                    'Pay',
                    'https://www.paypal.com/cgi-bin/webscr?' . http_build_query(
                        [
                            'cmd'    => '_ap-payment',
                            'paykey' => $response->payKey
                        ]
                    ),
                    [
                        'target' => '_blank'
                    ]
                );
            } else {
                D($response, 1);
            }
        }
    }
    */

    public function actionLogo()
    {
        header('Content-type: image/svg+xml');

        $size = 1024;

        echo '<?xml version="1.0" encoding="UTF-8" standalone="no"?>' . "\n";
        echo '<!DOCTYPE svg PUBLIC "-//W3C//DTD SVG 1.1//EN" "http://www.w3.org/Graphics/SVG/1.1/DTD/svg11.dtd">' . "\n";
        echo CHtml::openTag(
            'svg',
            [
                'version'     => "1.1",
                'baseProfile' => "full",
                'xmlns'       => "http://www.w3.org/2000/svg",
                'xmlns:xlink' => "http://www.w3.org/1999/xlink",
                'xmlns:ev'    => "http://www.w3.org/2001/xml-events",
                'width'       => "{$size}px",
                'height'      => "{$size}px"
            ]
        ) . "\n";
        $circleR = $size / 2 - 48;
        echo CHtml::tag(
            'circle',
            [
                'cx'   => $size / 2,
                'cy'   => $size / 2,
                'r'    => $circleR,
                'fill' => "#f2f2f2"
            ]
        ) . "\n";
        $circleStrokeWidth = 72;
        echo CHtml::tag(
            'circle',
            [
                'cx'           => $size / 2,
                'cy'           => $size / 2,
                'r'            => $circleR,
                'fill'         => "none",
                'stroke'       => "#1e8a8e",
                'stroke-width' => $circleStrokeWidth
            ]
        ) . "\n";

        $mSize = $size / 2;

        $mWidth   = 64;
        $mPadding = 16;
        $top      = new Line(0, -1, $size / 2 - $mSize / 2);
        $bottom   = new Line(0, -1, $size / 2 + $mSize / 2);

        //left
        $left1 = new Line(-1, 0, $size / 2 - $mSize / 2);

        $left2 = clone $left1;
        $left2->move(-$mWidth);

        $left3 = clone $left1;
        $left3->move(-$mWidth - $mPadding);

        $left4 = clone $left1;
        $left4->move(-$mWidth - $mPadding - $mWidth);

        //right
        $right1 = new Line(-1, 0, $size / 2 + $mSize / 2);

        $right2 = clone $right1;
        $right2->move($mWidth);

        $right3 = clone $right1;
        $right3->move($mWidth + $mPadding);

        $right4 = clone $right1;
        $right4->move($mWidth + $mPadding + $mWidth);

        $alpha    = 40;
        $tanAlpha = tan(pi() * ($alpha / 180));
        $A        = 1;
        $B        = -($A / $tanAlpha);
        $M0       = $left1->intersect($top);

        //topLeft
        $topLeft1 = new Line($A, $B, -($A * $M0['x'] + $B * $M0['y']));

        $topLeft2 = clone $topLeft1;
        $topLeft2->move(-$mWidth);

        $topLeft3 = clone $topLeft1;
        $topLeft3->move(-$mWidth - $mPadding);

        $topLeft4 = clone $topLeft1;
        $topLeft4->move(-$mWidth - $mPadding - $mWidth);

        $A  = 1;
        $B  = ($A / $tanAlpha);
        $M0 = $right1->intersect($top);
        //topRight
        $topRight1 = new Line($A, $B, -($A * $M0['x'] + $B * $M0['y']));

        $topRight2 = clone $topRight1;
        $topRight2->move($mWidth);

        $topRight3 = clone $topRight1;
        $topRight3->move($mWidth + $mPadding);

        $topRight4 = clone $topRight1;
        $topRight4->move($mWidth + $mPadding + $mWidth);


        /*
        echo $top->draw('black', $size);
        echo $bottom->draw('black', $size);

        echo $left1->draw('green', $size);
        echo $left2->draw('green', $size);
        echo $left3->draw('green', $size);
        echo $left4->draw('green', $size);

        echo $right1->draw('blue', $size);
        echo $right2->draw('blue', $size);
        echo $right3->draw('blue', $size);
        echo $right4->draw('blue', $size);

        echo $topLeft1->draw('red', $size);
        echo $topLeft2->draw('red', $size);
        echo $topLeft3->draw('red', $size);
        echo $topLeft4->draw('red', $size);

        echo $topRight1->draw('orange', $size);
        echo $topRight2->draw('orange', $size);
        echo $topRight3->draw('orange', $size);
        echo $topRight4->draw('orange', $size);
        */

        echo CHtml::openTag('g', ['fill' => '#1e8a8e']) . "\n";

        echo CHtml::tag(
            'polyline',
            [
                'points' => implode(
                    ' ',
                    [
                        implode(',', $left1->intersect($bottom)),
                        implode(',', $left1->intersect($topLeft3)),
                        implode(',', $left2->intersect($topLeft3)),
                        implode(',', $left2->intersect($bottom)),
                    ]
                )
            ]
        ) . "\n";

        echo CHtml::tag(
            'polyline',
            [
                'points' => implode(
                    ' ',
                    [
                        implode(',', $right1->intersect($bottom)),
                        implode(',', $right1->intersect($topRight3)),
                        implode(',', $right2->intersect($topRight3)),
                        implode(',', $right2->intersect($bottom)),
                    ]
                )
            ]
        ) . "\n";

        echo CHtml::tag(
            'polyline',
            [
                'points' => implode(
                    ' ',
                    [
                        implode(',', $left3->intersect($topLeft2)),
                        implode(',', $left3->intersect($topLeft1)),
                        implode(',', $topLeft1->intersect($topRight1)),
                        implode(',', $right3->intersect($topRight1)),
                        implode(',', $right3->intersect($topRight2)),
                        implode(',', $topRight2->intersect($topLeft2)),
                    ]
                )
            ]
        ) . "\n";

        echo CHtml::closeTag('g') . "\n";

        echo CHtml::openTag('g', ['fill' => '#c5c5c5']) . "\n";

        echo CHtml::tag(
            'polyline',
            [
                'points' => implode(
                    ' ',
                    [
                        implode(',', $left1->intersect($topLeft1)),
                        implode(',', $left2->intersect($topLeft1)),
                        implode(',', $left2->intersect($topLeft2)),
                        implode(',', $left1->intersect($topLeft2)),
                    ]
                )
            ]
        ) . "\n";

        echo CHtml::tag(
            'polyline',
            [
                'points' => implode(
                    ' ',
                    [
                        implode(',', $right1->intersect($topRight1)),
                        implode(',', $right2->intersect($topRight1)),
                        implode(',', $right2->intersect($topRight2)),
                        implode(',', $right1->intersect($topRight2)),
                    ]
                )
            ]
        ) . "\n";

        echo CHtml::tag(
            'polyline',
            [
                'points' => implode(
                    ' ',
                    [
                        implode(',', $left4->intersect($topLeft4)),
                        implode(',', $left4->intersect($bottom)),
                        implode(',', $left3->intersect($bottom)),
                        implode(',', $left3->intersect($topLeft3)),
                        implode(',', $topLeft3->intersect($topRight3)),
                        implode(',', $right3->intersect($topRight3)),
                        implode(',', $right3->intersect($bottom)),
                        implode(',', $right4->intersect($bottom)),
                        implode(',', $right4->intersect($topRight4)),
                        implode(',', $topRight4->intersect($topLeft4)),
                    ]
                )
            ]
        ) . "\n";

        echo CHtml::closeTag('g') . "\n";

        echo CHtml::closeTag('svg');
    }
}

class Line
{
    public $a;
    public $b;
    public $c;

    public function __construct($a, $b, $c)
    {
        $this->a = $a;
        $this->b = $b;
        $this->c = $c;
    }

    public function x($y)
    {
        return (-$this->c - $this->b * $y) / $this->a;
    }

    public function y($x)
    {
        return (-$this->c - $this->a * $x) / $this->b;
    }

    public function intersect(Line $line)
    {
        return [
            'x' => ($this->b * $line->c - $line->b * $this->c) / ($this->a * $line->b - $line->a * $this->b),
            'y' => ($this->c * $line->a - $line->c * $this->a) / ($this->a * $line->b - $line->a * $this->b),
        ];
    }

    public function move($d)
    {
        $this->c = $this->c - $d * sqrt(pow($this->a, 2) + pow($this->b, 2));
    }

    public function draw($color, $size)
    {
        if ($this->b != 0) {
            $left  = new Line(1, 0, 0);
            $right = new Line(1, 0, -$size);
            $p1    = $this->intersect($left);
            $p2    = $this->intersect($right);
        } else {
            $top    = new Line(0, 1, 0);
            $bottom = new Line(0, 1, -$size);
            $p1     = $this->intersect($top);
            $p2     = $this->intersect($bottom);
        }
        return CHtml::tag(
            'line',
            [
                'x1'           => $p1['x'],
                'x2'           => $p2['x'],
                'y1'           => $p1['y'],
                'y2'           => $p2['y'],
                'stroke'       => $color,
                'stroke-width' => '1'
            ]
        ) . "\n";
    }
}
