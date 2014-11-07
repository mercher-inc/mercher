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
    public function actionList()
    {
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
