<?php
/**
 * Project: mercher
 * Author: Dmitry Les
 * Date: 11/1/13
 * Time: 4:38 PM
 */

class WizardController extends Controller
{
    protected $_user;
    protected $_shop;

    public $defaultAction = 'step1';
    public $layout = '//layouts/wizard';

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
                'allow',
                'actions' => array(
                    'step1',
                    'step2',
                    'step3',
                ),
                'users'   => array('@'),
            ),
            array(
                'deny',
                'users' => array('*'),
            ),
        );
    }

    public function actionStep1()
    {
        if (count($this->user->shops) == 1) {
            $this->redirect(Yii::app()->urlManager->createUrl('wizard/step2'));
        } elseif (count($this->user->shops) > 1) {
            $this->redirect(Yii::app()->urlManager->createUrl('shops/index'));
        }

        $model = new Shop;

        if (isset($_POST['Shop'])) {
            $model->attributes = $_POST['Shop'];

            if ($model->save()) {
                $this->redirect(Yii::app()->urlManager->createUrl('wizard/step2'));
            }
        }

        $accounts = [];
        try {
            $result = Yii::app()->facebook->sdk->api('/me/accounts?fields=id,name&limit=50');
        } catch (FacebookApiException $e) {
            throw new CHttpException(500, $e->getMessage(), $e->getCode());
        }
        if (isset($result['data'])) {
            foreach ($result['data'] as $row) {
                $accounts[$row['id']] = $row['name'];
            }
        }

        $this->render(
            'step1',
            [
                'model'    => $model,
                'accounts' => $accounts
            ]
        );
    }

    public function actionStep2()
    {
        if (count($this->user->shops) < 1) {
            $this->redirect(Yii::app()->urlManager->createUrl('wizard/step1'));
        } elseif (count($this->user->shops) > 1) {
            $this->redirect(Yii::app()->urlManager->createUrl('shops/index'));
        }

        $shop = Shop::model()->findByAttributes(['owner_id' => $this->user->id]);

        if (count($shop->products) == 1) {
            $this->redirect(Yii::app()->urlManager->createUrl('wizard/step3'));
        } elseif (count($shop->products) > 1) {
            $this->redirect(Yii::app()->urlManager->createUrl('shops/index'));
        }

        $model          = new Product;
        $model->shop_id = $shop->id;

        if (isset($_POST['Product'])) {
            $model->attributes = $_POST['Product'];
            $model->shop_id    = $shop->id;

            if ($model->save()) {
                $this->redirect(Yii::app()->urlManager->createUrl('wizard/step2'));
            }
        }

        $this->render(
            'step2',
            [
                'model'          => $model,
                'shop'           => $shop
            ]
        );
    }

    public function actionStep3($request_token = null, $verification_code = null)
    {
        if (count($this->user->shops) < 1) {
            $this->redirect(Yii::app()->urlManager->createUrl('wizard/step1'));
        } elseif (count($this->user->shops) > 1) {
            $this->redirect(Yii::app()->urlManager->createUrl('shops/index'));
        }

        $shop = Shop::model()->findByAttributes(['owner_id' => $this->user->id]);

        if (!$request_token or !$verification_code) {
            $refundRequest                               = new \PayPalComponent\Request\RequestPermissionsRequest();
            $refundRequest->scope                        = [
                Shop::PAYPAL_PERMISSION_REFUND,
                Shop::PAYPAL_PERMISSION_ACCESS_BASIC_PERSONAL_DATA,
                Shop::PAYPAL_PERMISSION_ACCESS_ADVANCED_PERSONAL_DATA
            ];
            $refundRequest->callback                     = Yii::app()->createAbsoluteUrl(
                'wizard/step3'
            );
            $refundRequest->requestEnvelope->detailLevel = "ReturnAll";

            if (!$response = $refundRequest->submit()) {
                throw new CHttpException(500);
            } else {
                if ($response instanceof \PayPalComponent\Response\RequestPermissionsResponse) {
                    $this->render(
                        'step3',
                        [
                            'model'           => $shop,
                            'grantPermissionUrl' => 'https://www.paypal.com/cgi-bin/webscr?' . http_build_query(
                                [
                                    'cmd'           => '_grant-permission',
                                    'request_token' => $response->token
                                ]
                            )
                        ]
                    );
                } elseif ($response instanceof \PayPalComponent\Response\PPFaultMessage) {
                    throw new CHttpException(500);
                } else {
                    throw new CHttpException(500);
                }
            }
        } else {
            $refundRequest                               = new \PayPalComponent\Request\GetAccessTokenRequest();
            $refundRequest->token                        = $request_token;
            $refundRequest->verifier                     = $verification_code;
            $refundRequest->requestEnvelope->detailLevel = "ReturnAll";

            if (!$response = $refundRequest->submit()) {
                throw new CHttpException(500);
            } else {
                if ($response instanceof \PayPalComponent\Response\GetAccessTokenResponse) {
                    $shop->paypalPermissions   = $response->scope;
                    $shop->paypal_token        = $response->token;
                    $shop->paypal_token_secret = $response->tokenSecret;
                } elseif ($response instanceof \PayPalComponent\Response\PPFaultMessage) {
                    throw new CHttpException(500);
                } else {
                    throw new CHttpException(500);
                }
            }

            $refundRequest                               = new \PayPalComponent\Request\GetAdvancedPersonalDataRequest();
            $refundRequest->attributeList                = [
                'attribute' => [
                    'http://axschema.org/company/name',
                    'http://axschema.org/contact/email'
                ]
            ];
            $refundRequest->requestEnvelope->detailLevel = "ReturnAll";

            Yii::import('ext.paypal.sdk-core-php.lib.PayPal.Auth.Oauth.AuthSignature', true);
            Yii::import('ext.paypal.sdk-core-php.lib.PayPal.Auth.Oauth.OAuthServer', true);
            Yii::import('ext.paypal.sdk-core-php.lib.PayPal.Auth.Oauth.OAuthDataStore', true);
            Yii::import('ext.paypal.sdk-core-php.lib.PayPal.Auth.Oauth.MockOAuthDataStore', true);
            Yii::import('ext.paypal.sdk-core-php.lib.PayPal.Auth.Oauth.OAuthConsumer', true);
            Yii::import('ext.paypal.sdk-core-php.lib.PayPal.Auth.Oauth.OAuthToken', true);
            Yii::import('ext.paypal.sdk-core-php.lib.PayPal.Auth.Oauth.OAuthSignatureMethod', true);
            Yii::import('ext.paypal.sdk-core-php.lib.PayPal.Auth.Oauth.OAuthSignatureMethodHmacSha1', true);
            Yii::import('ext.paypal.sdk-core-php.lib.PayPal.Auth.Oauth.OAuthRequest', true);
            Yii::import('ext.paypal.sdk-core-php.lib.PayPal.Auth.Oauth.OAuthUtil', true);

            $authSignature = new PayPal\Auth\Oauth\AuthSignature();
            $refundRequest->authHeader = $authSignature->generateFullAuthString(
                $refundRequest->client->userId,
                $refundRequest->client->password,
                $shop->paypal_token,
                $shop->paypal_token_secret,
                'POST',
                $refundRequest->endpoint()
            );

            if (!$response = $refundRequest->submit()) {
                throw new CHttpException(500);
            } else {
                if ($response instanceof \PayPalComponent\Response\GetAdvancedPersonalDataResponse) {
                    foreach ($response->response['personalData'] as $personalDataRow) {
                        if ($personalDataRow['personalDataKey'] == 'http://axschema.org/contact/email') {
                            $shop->pp_merchant_id = $personalDataRow['personalDataValue'];
                        }
                    }
                } elseif ($response instanceof \PayPalComponent\Response\PPFaultMessage) {
                    throw new CHttpException(500);
                } else {
                    throw new CHttpException(500);
                }
            }

            if (!$shop->save()) {
                throw new CHttpException(500);
            } else {
                $this->redirect(Yii::app()->urlManager->createUrl('shops/index'));
            }
        }
    }

    public function getUser()
    {
        if (!$this->_user) {
            $this->_user = User::model()->findByPk(Yii::app()->user->id);
            if (!$this->_user) {
                $this->redirect(Yii::app()->urlManager->createUrl('index/index'));
            }
        }
        return $this->_user;
    }
}