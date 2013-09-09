<?php

class ApiModule extends CWebModule
{
    public $controllerNamespace = 'api\controllers';

    public function init()
    {
        // this method is called when the module is being created
        // you may place code here to customize the module or the application

        // import the module-level models and components
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

        /*
        //var_dump();
        Yii::app()->urlManager->addRules(require(dirname(__FILE__).'/config/rest_routes.php'));
        var_dump(Yii::app()->urlManager);
        */
    }

    public function beforeControllerAction($controller, $action)
    {
        //var_dump(Yii::app()->request->hostInfo, $_SERVER['HTTP_HOST'], Yii::app()->request);

        if (parent::beforeControllerAction($controller, $action)) {
            header('Content-type: application/json');
            return true;
        } else {
            return false;
        }
    }
}
