<?php

class ExportModule extends CWebModule
{
    public $controllerNamespace = 'export\controllers';

    public function init()
    {
        $this->setImport(
            [
                'export.models.*',
                'export.components.*',
            ]
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
