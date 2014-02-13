<?php
/**
 * Project: mercher
 * Author: Dmitry Les
 * Date: 12/11/13
 * Time: 6:31 PM
 */

namespace api\controllers;


class RpcController extends \CController
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
                'actions' => array(
                    'like',
                    'create_order',
                    'create_pay_request'
                ),
                'users'   => array('@'),
            ),
            array(
                'deny',
                'users' => array('*'),
            ),
        );
    }

    public function actions()
    {
        return [
            'create_order'       => '\api\controllers\rpc\CreateOrderAction',
            'create_pay_request' => '\api\controllers\rpc\CreatePayRequestAction',
        ];
    }

    public function actionLike($product_id)
    {
        $product = \Product::model()->findByPk((int)$product_id);

        if (!$product) {
            throw new \CHttpException(404, 'Product not found');
        }

        if (\Yii::app()->user->id != $product->shop->owner_id) {
            throw new \CHttpException(403, 'Permission denied');
        }

        try {
            $result = \Yii::app()->facebook->sdk->api(
                '/' . $product->shop->fb_id . '?' . http_build_query(['fields' => 'access_token'])
            );
        } catch (\FacebookApiException $e) {
            throw new \CHttpException($e->getCode(), $e->getMessage());
        }

        if (!isset($result['access_token'])) {
            throw new \CHttpException(403, 'Permission denied');
        }

        $pageAccessToken = $result['access_token'];

        try {
            $result = \Yii::app()->facebook->sdk->api(
                'me/og.likes',
                'POST',
                array(
                    'object'       => $product->fb_id,
                    'access_token' => $pageAccessToken
                )
            );
        } catch (\FacebookApiException $e) {
            throw new \CHttpException($e->getCode(), $e->getMessage());
        }

        echo \CJSON::encode($result);
    }

}