<?php
/**
 * Created by JetBrains PhpStorm.
 * Project: mercher
 * Author: dmitry
 * Date: 9/9/13
 * Time: 4:33 PM
 */

namespace export\controllers;


class OrdersController extends \Controller
{
    public function actionList($password)
    {
        if ($password != '4f3969cdb80a752c372e2dbcd30f163431b6f587') {
            throw new \CHttpException(403, 'Wrong password');
        }

        $result = array();

        $orders   = \Order::model()->findAll();

        if (count($orders)) {
            foreach ($orders as $order) {
                $model             = $order->attributes;

                $model['orderItems'] = array();
                foreach ($order->orderItems as $orderItem) {
                    $model['orderItems'][] = $orderItem->attributes;
                }
                $result[] = $model;
            }
        }
        echo \CJSON::encode($result);
    }
}
