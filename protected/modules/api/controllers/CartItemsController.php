<?php
/**
 * Project: mercher
 * Author: Dmitry Les
 * Date: 2/7/14
 * Time: 6:01 PM
 */

namespace api\controllers;

use Yii,
    CJSON,
    CHttpException,
    User,
    CartItem;

class CartItemsController extends \CController
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
                'allow',
                'actions' => ['list', 'create', 'read', 'update', 'delete'],
                'users'   => ['@']
            ),
            array(
                'deny',
                'users' => array('*'),
            ),
        );
    }

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

        $user = User::model()->findByPk(Yii::app()->user->id);

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
                ],
                'order'=>"t.created"
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

        $user = User::model()->findByPk(Yii::app()->user->id);

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

    public function actionRead($shop_id, $cart_item_id)
    {
        $shop = \Shop::model()->findByPk($shop_id);
        if (!$shop) {
            throw new \CHttpException(404, \Yii::t('error', 'shop_not_found'));
        }

        $cartItem = \CartItem::model()->findByPk($cart_item_id);
        if (!$cartItem) {
            throw new \CHttpException(404, \Yii::t('error', 'cart_item_not_found'));
        }

        $user = User::model()->findByPk(Yii::app()->user->id);

        if ($cartItem->user_id != $user->id) {
            throw new CHttpException(403);
        }

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

        $user = User::model()->findByPk(Yii::app()->user->id);

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

    public function actionDelete($shop_id, $cart_item_id)
    {
        $shop = \Shop::model()->findByPk($shop_id);
        if (!$shop) {
            throw new \CHttpException(404, \Yii::t('error', 'shop_not_found'));
        }

        $cartItem = \CartItem::model()->findByPk($cart_item_id);
        if (!$cartItem) {
            throw new \CHttpException(404, \Yii::t('error', 'cart_item_not_found'));
        }

        $user = User::model()->findByPk(Yii::app()->user->id);

        if ($cartItem->user_id != $user->id) {
            throw new CHttpException(403);
        }

        if ($cartItem->delete()) {
            header('HTTP/1.1 204 No Content');
            Yii::app()->end();
        } else {
            $errors = $cartItem->getErrors();
            $a      = [];
            parse_str(http_build_query($errors), $a);
            echo \CJSON::encode(['errors' => $a]);

            header('HTTP/1.1 422 Unprocessable Entity');
            Yii::app()->end();
        }
    }

}