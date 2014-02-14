<?php

namespace api\controllers;

class DefaultController extends \Controller
{
    public function actionIndex()
    {
        echo \CJSON::encode($_GET);
    }

    public function actionError()
    {
        if ($error = \Yii::app()->errorHandler->error) {
            $errorData = [
                'error'=> [
                    'code' => $error['errorCode'],
                    'message' => $error['message'],
                ]
            ];
            switch ($error['code']) {
                case 406:
                    $errorData['error']['validation_errors'] = $error['validationErrors'];
            }
            echo \CJSON::encode($errorData);
        }
    }
}