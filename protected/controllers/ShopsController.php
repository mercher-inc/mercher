<?php
/**
 * Created by JetBrains PhpStorm.
 * Project: mercher
 * Author: dmitry
 * Date: 9/5/13
 * Time: 1:40 PM
 */

class ShopsController extends Controller
{
    protected $_shop;

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
                'actions' => array('index'),
                'roles'   => array( //AuthManager::PERMISSION_READ_SHOP
                )
            ),
            array(
                'allow',
                'actions' => array('create'),
                'roles'   => array(
                    AuthManager::PERMISSION_CREATE_SHOP
                )
            ),
            array(
                'allow',
                'actions' => array('read'),
                'roles'   => array(
                    AuthManager::PERMISSION_READ_SHOP => array(
                        'shop_id' => Yii::app()->request->getParam('shop_id'),
                    )
                )
            ),
            array(
                'allow',
                'actions' => array('update', 'updatePayPalAccount'),
                'roles'   => array(
                    AuthManager::PERMISSION_UPDATE_SHOP => array(
                        'shop_id' => Yii::app()->request->getParam('shop_id'),
                    )
                )
            ),
            array(
                'allow',
                'actions' => array('delete'),
                'roles'   => array(
                    AuthManager::PERMISSION_DELETE_SHOP => array(
                        'shop_id' => Yii::app()->request->getParam('shop_id'),
                    )
                )
            ),
            array(
                'deny',
                'users' => array('*'),
            ),
        );
    }

    public function actionIndex()
    {
        $user = User::model()->findByPk(Yii::app()->user->id);

        $ownedShops = $user->shops(['limit' => 1, 'order' => 'created']);

        if (count($ownedShops)) {
            $this->redirect(Yii::app()->urlManager->createUrl('shops/read', ['shop_id' => $ownedShops[0]->id]));
            return;
        }

        $managedShops = $user->managedShops(['limit' => 1, 'order' => 'created']);

        if (count($managedShops)) {
            $this->redirect(Yii::app()->urlManager->createUrl('shops/read', ['shop_id' => $managedShops[0]->id]));
            return;
        }

        $this->redirect(Yii::app()->urlManager->createUrl('wizard'));
    }

    public function actionRead()
    {
        if (Yii::app()->user->checkAccess(AuthManager::PERMISSION_READ_PRODUCT, ['shop_id' => $this->shop->id])) {
            $this->redirect(Yii::app()->urlManager->createUrl('products/index', ['shop_id' => $this->shop->id]));
        } elseif (Yii::app()->user->checkAccess(
            AuthManager::PERMISSION_READ_CATEGORY,
            ['shop_id' => $this->shop->id]
        )
        ) {
            $this->redirect(Yii::app()->urlManager->createUrl('categories/index', ['shop_id' => $this->shop->id]));
        } elseif (Yii::app()->user->checkAccess(AuthManager::PERMISSION_UPDATE_SHOP, ['shop_id' => $this->shop->id])) {
            $this->redirect(Yii::app()->urlManager->createUrl('shops/update', ['shop_id' => $this->shop->id]));
        } else {
            throw new CHttpException(403, 'You are not authorized to perform this action.');
        }
    }

    public function actionCreate()
    {
        $this->shop = new Shop;

        if (Yii::app()->request->isPostRequest) {
            $this->shop->attributes = $_POST;

            if ($this->shop->save()) {
                $this->shop->refresh();
                $this->redirect(Yii::app()->urlManager->createUrl('shops/index'));
            }
        }

        //var_dump($this->shop);

        $this->render(
            'create',
            array(
                'shop' => $this->shop
            )
        );
    }

    public function actionUpdate()
    {
        $this->layout = '//layouts/shop';

        if (isset($_POST['Shop'])) {
            $this->shop->attributes = $_POST['Shop'];

            if ($this->shop->save()) {
                $this->redirect(['index']);
            }
        }

        $this->render(
            'update',
            array(
                'model' => $this->shop,
            )
        );
    }

    public function actionUpdatePayPalAccount($shop_id, $request_token = null, $verification_code = null)
    {
        $shop = Shop::model()->findByPk($shop_id);

        if (!$request_token or !$verification_code) {
            $refundRequest                               = new \PayPalComponent\Request\RequestPermissionsRequest();
            $refundRequest->scope                        = [
                Shop::PAYPAL_PERMISSION_REFUND,
                Shop::PAYPAL_PERMISSION_ACCESS_BASIC_PERSONAL_DATA,
                Shop::PAYPAL_PERMISSION_ACCESS_ADVANCED_PERSONAL_DATA
            ];
            $refundRequest->callback                     = Yii::app()->createAbsoluteUrl(
                'shops/UpdatePayPalAccount',
                ['shop_id' => $shop_id]
            );
            $refundRequest->requestEnvelope->detailLevel = "ReturnAll";

            if (!$response = $refundRequest->submit()) {
                throw new CHttpException(500);
            } else {
                if ($response instanceof \PayPalComponent\Response\RequestPermissionsResponse) {
                    $this->redirect(
                        'https://www.paypal.com/cgi-bin/webscr?' . http_build_query(
                            [
                                'cmd'           => '_grant-permission',
                                'request_token' => $response->token
                            ]
                        )
                    );
                } elseif ($response instanceof \PayPalComponent\Response\PPFaultMessage) {
                    D($response, 1);
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
                    D($response, 1);
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
                    D($response, 1);
                } else {
                    throw new CHttpException(500);
                }
            }

            if (!$shop->save()) {
                D($shop, 1);
            } else {
                $this->redirect(['/shops/update', 'shop_id' => $shop->id]);
            }
        }
    }

    public function getShop()
    {
        if (!$this->_shop) {
            $this->_shop = Shop::model()->findByPk(Yii::app()->request->getParam('shop_id'));
            if (!$this->_shop) {
                throw new CHttpException(404);
            }
        }
        return $this->_shop;
    }

    public function setShop(Shop $shop)
    {
        $this->_shop = $shop;
    }
}