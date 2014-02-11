<?php

class TabModule extends CWebModule
{
	public function init()
	{
		// this method is called when the module is being created
		// you may place code here to customize the module or the application

		// import the module-level models and components
		$this->setImport(array(
			'tab.models.*',
			'tab.components.*',
		));
	}

	public function beforeControllerAction($controller, $action)
	{
		if(parent::beforeControllerAction($controller, $action))
		{
            /**
             * @var $clientScript CClientScript
             */
            $clientScript = Yii::app()->clientScript;
            $clientScript->registerMetaTag('en', 'language');
            $clientScript->registerMetaTag('text/html; charset=UTF-8', null, 'Content-Type');
            $clientScript->registerMetaTag(
                implode(
                    ', ',
                    [
                        'width=device-width',
                        'initial-scale=1.0',
                        'minimum-scale=1.0',
                        'maximum-scale=1.0',
                        'user-scalable=no'
                    ]
                ),
                'viewport'
            );
            $controller->layout = 'main';

			return true;
		}
		else
			return false;
	}
}
