<?php

class ApiModule extends CWebModule
{
    public $controllerNamespace = 'api\controllers';

    public $controllerMap = [
        'cart_items' => [
            'class' => '\api\controllers\CartItemsController',
        ],
        'order_items' => [
            'class' => '\api\controllers\OrderItemsController',
        ]
    ];

    public function init()
    {
        $this->setImport(
            [
                'api.models.*',
                'api.components.*',
            ]
        );

        Yii::app()->setComponents(
            [
                'errorHandler' => [
                    'errorAction' => 'api/default/error',
                ],
                'user'         => [
                    'class'           => 'CWebUser',
                    'allowAutoLogin'  => true,
                    'stateKeyPrefix'  => 'api',
                    'loginUrl'        => null,
                ],
            ]
        );

        if (!Yii::app()->user->isGuest) {
            if (Yii::app()->user->getState('fb_id', null) != Yii::app()->facebook->sdk->getUser()) {
                Yii::app()->user->logout();
            }
        }
        if (Yii::app()->user->isGuest) {
            $identity = new UserIdentity();
            $identity->authenticate();
            if($identity->authenticate())
            {
                Yii::app()->user->login($identity, 60*60*24);
            }
        }
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
