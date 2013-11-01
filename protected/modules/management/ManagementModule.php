<?php

class ManagementModule extends CWebModule
{
    public $defaultController = 'index';

    public $password = 'admin';

    public function init()
    {
        parent::init();

        $this->setImport(
            array(
                'management.models.*',
                'management.components.*',
            )
        );

        Yii::app()->setComponents(array(
                'errorHandler'=>array(
                    'class'=>'CErrorHandler',
                    'errorAction'=>$this->getId().'/index/error',
                ),
                'user'=>array(
                    'class'=>'CWebUser',
                    'stateKeyPrefix'=>'management',
                    'loginUrl'=>Yii::app()->createUrl($this->getId().'/index/login'),
                )
            ), false);
    }

    public function beforeControllerAction($controller, $action)
    {
        if(parent::beforeControllerAction($controller, $action))
        {
            $route=$controller->id.'/'.$action->id;

            $publicPages=array(
                'index/login',
                'index/error',
            );

            if($this->password!==false && Yii::app()->user->isGuest && !in_array($route,$publicPages))
                Yii::app()->user->loginRequired();
            else
                return true;
        }
        return false;
    }
}
