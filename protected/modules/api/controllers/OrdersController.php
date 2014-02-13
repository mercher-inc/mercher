<?php
/**
 * Project: mercher
 * Author: Dmitry Les
 * Date: 2/12/14
 * Time: 7:37 PM
 */

namespace api\controllers;

use Yii,
    Controller,
    Shop,
    User,
    Order,
    CHttpException,
    CJSON;

class OrdersController extends Controller
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

        $shop = Shop::model()->findByPk($shop_id);
        if (!$shop) {
            throw new CHttpException(404, Yii::t('error', 'shop_not_found'));
        }

        $user = User::model()->findByPk(Yii::app()->user->id);

        $result['count'] = (int)Order::model()->countByAttributes(
            [
                'shop_id' => $shop->id,
                'user_id' => $user->id
            ]
        );

        $orders = Order::model()->findAllByAttributes(
            [
                'shop_id' => $shop->id,
                'user_id' => $user->id
            ],
            [
                'offset' => $offset,
                'limit'  => $limit,
                'order'  => "t.created DESC"
            ]
        );

        if (count($orders)) {
            foreach ($orders as $order) {
                $model              = $order->attributes;
                $result['models'][] = $model;
            }
        }

        echo CJSON::encode($result);
    }

    public function actionRead($shop_id, $order_id)
    {
        $shop = Shop::model()->findByPk($shop_id);
        if (!$shop) {
            throw new CHttpException(404, Yii::t('error', 'shop_not_found'));
        }

        $order = Order::model()->findByPk($order_id);
        if (!$order) {
            throw new CHttpException(404, Yii::t('error', 'order_not_found'));
        }

        $user = User::model()->findByPk(Yii::app()->user->id);

        if ($order->user_id != $user->id) {
            throw new CHttpException(403);
        }

        $model = $order->attributes;
        echo CJSON::encode($model);
    }
}