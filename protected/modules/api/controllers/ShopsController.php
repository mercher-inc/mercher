<?php
/**
 * Created by JetBrains PhpStorm.
 * Project: mercher
 * Author: dmitry
 * Date: 9/9/13
 * Time: 11:41 AM
 */

namespace api\controllers;


class ShopsController extends \Controller
{
    public function init()
    {
        if (\Yii::app()->user->isGuest) {
            throw new \CHttpException(401, \Yii::t('error', 'unauthorized'));
        }
    }

    public function actionList()
    {
        echo \CJSON::encode(\Shops::model()->readRestCollection($_GET));
    }

    public function actionRead()
    {
        echo \CJSON::encode(\Shops::model()->readRestModel($_GET));
    }

    public function actionCreate()
    {
        echo \CJSON::encode(
            \Shops::model()->createRestModel(\CJSON::decode(\Yii::app()->request->getRawBody()), $_GET)
        );
    }

    public function actionUpdate()
    {
        echo \CJSON::encode(
            \Shops::model()->updateRestModel(\CJSON::decode(\Yii::app()->request->getRawBody()), $_GET)
        );
    }

    public function actionDelete()
    {
        \CJSON::encode(\Shops::model()->deleteRestModel($_GET));
        http_response_code(204);
    }
}