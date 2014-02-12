<?php

class ApiModule extends CWebModule
{
    public $controllerNamespace = 'api\controllers';

    public $controllerMap=[
        'cart_items' => [
            'class' => '\api\controllers\CartItemsController'
        ]
    ];

    public function init()
    {
        $this->setImport(
            array(
                'api.models.*',
                'api.components.*',
            )
        );

        Yii::app()->setComponents(
            array(
                'errorHandler' => array(
                    'errorAction' => 'api/default/error',
                ),
            )
        );
    }

    public function beforeControllerAction($controller, $action)
    {
        if (parent::beforeControllerAction($controller, $action)) {
            header('Content-type: application/json');
            return true;
        } else {
            return false;
        }
    }
}
