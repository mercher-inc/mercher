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
        $this->render('index');
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
        Yii::log(print_r($_REQUEST, true), CLogger::LEVEL_WARNING, 'test');
    }
    */
}