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
            switch ($error['code']) {
                case 500:
                    echo \CJSON::encode(array('error' => array('message' => \Yii::t('error', 'internal'))));
                    break;
                case 406:
                    echo \CJSON::encode(
                        array(
                            'error' => array(
                                'message' => $error['message'],
                                'validation_errors' => $error['validationErrors']
                            )
                        )
                    );
                    break;
                default:
                    echo \CJSON::encode(array('error' => array('message' => $error['message'])));
            }
        }
    }
}