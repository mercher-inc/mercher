<?php
/**
 * Project: mercher
 * Author: Dmitry Les
 * Date: 2/7/14
 * Time: 6:01 PM
 */

namespace api\controllers;

use Yii,
    CHttpCookie,
    CJSON,
    CHttpException,
    User,
    CartItem,
    CDbExpression;

class CartItemsController extends \CController
{
    public function actionList($shop_id, $offset = 0, $limit = 10)
    {
        $offset = (int)$offset;
        $limit  = (int)$limit;

        $result = array(
            'models' => array(),
            'count'  => 0,
            'offset' => $offset,
            'limit'  => $limit,
        );

        $shop = \Shop::model()->findByPk($shop_id);
        if (!$shop) {
            throw new \CHttpException(404, \Yii::t('error', 'shop_not_found'));
        }

        $fbUserId = Yii::app()->facebook->sdk->getUser();

        if (!$fbUserId) {
            throw new CHttpException(403);
        }

        $user = User::model()->findByAttributes(['fb_id' => $fbUserId]);
        if (!$user) {
            try {
                $fbUser = Yii::app()->facebook->sdk->api('/me?scope=email');
            } catch (\FacebookApiException $e) {
                throw new CHttpException(403);
            }
            $user             = new User();
            $user->fb_id      = $fbUserId;
            $user->email      = $fbUser['email'];
            $user->first_name = isset($fbUser['first_name']) ? $fbUser['first_name'] : null;
            $user->last_name  = isset($fbUser['last_name']) ? $fbUser['last_name'] : null;
            $user->last_login = new CDbExpression('NOW()');
            $user->save();
        }

        $criteria = new \CDbCriteria;

        $productTable = \Product::model()->tableName();
        $productAlias = 'p';

        $criteria->mergeWith(
            [
                'join'      => "JOIN $productTable AS \"$productAlias\" ON \"t\".\"product_id\" = \"$productAlias\".\"id\"",
                'condition' => "\"$productAlias\".\"shop_id\" = :shopId AND \"t\".\"user_id\" = :userId",
                'params'    => [
                    'shopId' => $shop->id,
                    'userId' => $user->id
                ]
            ]
        );

        $result['count'] = (int)CartItem::model()->count($criteria);

        $criteria->offset = $offset;
        $criteria->limit = $limit;

        $cartItems = CartItem::model()->findAll($criteria);

        if (count($cartItems)) {
            foreach ($cartItems as $cartItem) {
                $model            = $cartItem->attributes;
                $model['product'] = $cartItem->product ? $cartItem->product->attributes : null;

                if ($cartItem->product->image_id) {
                    $image = $cartItem->product->image->attributes;
                    try {
                        $model['product']['image'] = \CJSON::decode($image['data']);
                    } catch (\Exception $e) {
                        $model['product']['image'] = [];
                    }
                }
                $result['models'][] = $model;
            }
        }

        echo \CJSON::encode($result);
    }

    public function actionRead($shop_id, $product_id)
    {

    }

    public function actionCreate($shop_id)
    {
        $shop = \Shop::model()->findByPk($shop_id);
        if (!$shop) {
            throw new \CHttpException(404, \Yii::t('error', 'shop_not_found'));
        }

        try {
            $attributes = CJSON::decode(Yii::app()->request->getRawBody());
        } catch (\CException $e) {
            throw new CHttpException(406);
        }

        $fbUserId = Yii::app()->facebook->sdk->getUser();

        if (!$fbUserId) {
            throw new CHttpException(403);
        }

        $user = User::model()->findByAttributes(['fb_id' => $fbUserId]);
        if (!$user) {
            try {
                $fbUser = Yii::app()->facebook->sdk->api('/me?scope=email');
            } catch (\FacebookApiException $e) {
                throw new CHttpException(403);
            }
            $user             = new User();
            $user->fb_id      = $fbUserId;
            $user->email      = $fbUser['email'];
            $user->first_name = isset($fbUser['first_name']) ? $fbUser['first_name'] : null;
            $user->last_name  = isset($fbUser['last_name']) ? $fbUser['last_name'] : null;
            $user->last_login = new CDbExpression('NOW()');
            $user->save();
        }

        if (!isset($attributes['product_id'])) {
            throw new \CHttpException(404, \Yii::t('error', 'product_not_found'));
        }

        $product = \Product::model()->findByPk($attributes['product_id']);

        if (!$product) {
            throw new \CHttpException(404, \Yii::t('error', 'product_not_found'));
        }

        $amount = isset($attributes['amount']) ? (int)$attributes['amount'] : 1;

        $cartItem = false;
        if (isset($attributes['product_id'])) {
            $cartItem = CartItem::model()->findByAttributes(
                [
                    'product_id' => $attributes['product_id'],
                    'user_id'    => $user->id
                ]
            );
        }

        if (!$cartItem) {
            $cartItem             = new CartItem();
            $cartItem->user_id    = $user->id;
            $cartItem->product_id = $product->id;
        }

        $cartItem->amount = $amount;

        if ($cartItem->save()) {
            $cartItem->refresh();
            $model            = $cartItem->attributes;
            $model['product'] = $cartItem->product ? $cartItem->product->attributes : null;
            if ($cartItem->product->image_id) {
                $image = $cartItem->product->image->attributes;
                try {
                    $model['product']['image'] = \CJSON::decode($image['data']);
                } catch (\Exception $e) {
                    $model['product']['image'] = [];
                }
            }
            echo \CJSON::encode($model);
        } else {
            $errors = $cartItem->getErrors();
            $a      = [];
            parse_str(http_build_query($errors), $a);
            echo \CJSON::encode(['errors' => $a]);

            header('HTTP/1.1 422 Unprocessable Entity');
            Yii::app()->end();
        }
    }

    public function actionUpdate($shop_id, $cart_item_id)
    {
        $shop = \Shop::model()->findByPk($shop_id);
        if (!$shop) {
            throw new \CHttpException(404, \Yii::t('error', 'shop_not_found'));
        }

        $cartItem = \CartItem::model()->findByPk($cart_item_id);
        if (!$cartItem) {
            throw new \CHttpException(404, \Yii::t('error', 'cart_item_not_found'));
        }

        try {
            $attributes = CJSON::decode(Yii::app()->request->getRawBody());
        } catch (\CException $e) {
            throw new CHttpException(406);
        }

        $fbUserId = Yii::app()->facebook->sdk->getUser();

        if (!$fbUserId) {
            throw new CHttpException(403);
        }

        $user = User::model()->findByAttributes(['fb_id' => $fbUserId]);
        if (!$user) {
            try {
                $fbUser = Yii::app()->facebook->sdk->api('/me?scope=email');
            } catch (\FacebookApiException $e) {
                throw new CHttpException(403);
            }
            $user             = new User();
            $user->fb_id      = $fbUserId;
            $user->email      = $fbUser['email'];
            $user->first_name = isset($fbUser['first_name']) ? $fbUser['first_name'] : null;
            $user->last_name  = isset($fbUser['last_name']) ? $fbUser['last_name'] : null;
            $user->last_login = new CDbExpression('NOW()');
            $user->save();
        }

        if ($cartItem->user_id != $user->id) {
            throw new CHttpException(403);
        }

        $amount = isset($attributes['amount']) ? (int)$attributes['amount'] : 1;

        $cartItem->amount = $amount;

        if ($cartItem->save()) {
            $cartItem->refresh();
            $model            = $cartItem->attributes;
            $model['product'] = $cartItem->product ? $cartItem->product->attributes : null;
            if ($cartItem->product->image_id) {
                $image = $cartItem->product->image->attributes;
                try {
                    $model['product']['image'] = \CJSON::decode($image['data']);
                } catch (\Exception $e) {
                    $model['product']['image'] = [];
                }
            }
            echo \CJSON::encode($model);
        } else {
            $errors = $cartItem->getErrors();
            $a      = [];
            parse_str(http_build_query($errors), $a);
            echo \CJSON::encode(['errors' => $a]);

            header('HTTP/1.1 422 Unprocessable Entity');
            Yii::app()->end();
        }
    }

    public function actionAdd()
    {
        D($this->cartKey);
    }

    public function actionOrder()
    {
        $payRequest                               = new \PayPalComponent\Request\PayRequest();
        $payRequest->actionType                   = \PayPalComponent\Request\PayRequest::ACTION_TYPE_PAY_PRIMARY;
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
                'amount'      => 1.00,
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

        if (!$response = $payRequest->submit()) {
            D($payRequest, 1);
        } else {
            if ($response instanceof \PayPalComponent\Response\PayResponse) {
                D($response);
                echo CHtml::link(
                    'Pay',
                    'https://www.sandbox.paypal.com/cgi-bin/webscr?' . http_build_query(
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

    protected function getCartKey()
    {
        if (Yii::app()->request->cookies['cartKey'] === null) {
            Yii::app()->request->cookies['cartKey'] = new CHttpCookie(
                'cartKey',
                sha1(time() . rand()),
                [
                    'expire'   => strtotime('+10 years'),
                    'httpOnly' => true
                ]
            );
        }
        return (string)Yii::app()->request->cookies['cartKey'];
    }

}