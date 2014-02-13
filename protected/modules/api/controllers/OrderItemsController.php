<?php
/**
 * Project: mercher
 * Author: Dmitry Les
 * Date: 2/13/14
 * Time: 3:25 PM
 */

namespace api\controllers;

use Yii,
    CController,
    Shop,
    Order,
    User,
    OrderItem,
    CHttpException,
    CDbCriteria;

class OrderItemsController extends CController
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
                'actions' => ['list', 'read'],
                'users'   => ['@']
            ),
            array(
                'deny',
                'users' => array('*'),
            ),
        );
    }

    public function actionList($shop_id, $order_id, $offset = 0, $limit = 10)
    {
        $offset = (int)$offset;
        $limit  = (int)$limit;

        $result = array(
            'models' => array(),
            'count'  => 0,
            'offset' => $offset,
            'limit'  => $limit,
        );

        $shop = Shop::model()->findByPk($shop_id);
        if (!$shop) {
            throw new CHttpException(404, Yii::t('error', 'shop_not_found'));
        }

        $order = Order::model()->findByPk($order_id);
        if (!$order) {
            throw new CHttpException(404, Yii::t('error', 'order_not_found'));
        }

        if ($order->shop_id != $shop->id) {
            throw new CHttpException(404, Yii::t('error', 'order_not_found'));
        }

        $user = User::model()->findByPk(Yii::app()->user->id);

        if ($order->user_id != $user->id) {
            throw new CHttpException(403);
        }

        $result['count'] = (int)OrderItem::model()->countByAttributes(
            [
                'order_id' => $order->id
            ]
        );

        $orderItems = OrderItem::model()->findAllByAttributes(
            [
                'order_id' => $order->id
            ],
            [
                'offset' => $offset,
                'limit'  => $limit,
                'order'  => "t.created",
                'with' => 'product'
            ]
        );

        if (count($orderItems)) {
            foreach ($orderItems as $orderItem) {
                $model            = $orderItem->attributes;
                $model['product'] = $orderItem->product ? $orderItem->product->attributes : null;

                if ($orderItem->product->image_id) {
                    $image = $orderItem->product->image->attributes;
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

}