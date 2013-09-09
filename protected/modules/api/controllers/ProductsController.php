<?php
/**
 * Created by JetBrains PhpStorm.
 * Project: mercher
 * Author: dmitry
 * Date: 9/9/13
 * Time: 4:33 PM
 */

namespace api\controllers;


class ProductsController extends \Controller
{
    public function init()
    {
        if (\Yii::app()->user->isGuest) {
            throw new \CHttpException(401, \Yii::t('error', 'unauthorized'));
        }
    }

    public function actionList()
    {
        echo \CJSON::encode(\Products::model()->readRestCollection($_GET));
    }

    public function actionRead()
    {
        echo \CJSON::encode(\Products::model()->readRestModel($_GET));
    }

    public function actionCreate()
    {
        echo \CJSON::encode(
            \Products::model()->createRestModel(\CJSON::decode(\Yii::app()->request->getRawBody()), $_GET)
        );
    }

    public function actionUpdate()
    {
        echo \CJSON::encode(
            \Products::model()->updateRestModel(\CJSON::decode(\Yii::app()->request->getRawBody()), $_GET)
        );
    }

    public function actionDelete()
    {
        \CJSON::encode(\Products::model()->deleteRestModel($_GET));
        http_response_code(204);
    }
}