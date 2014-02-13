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

        Yii::app()->setComponents(
            [
                'errorHandler' => [
                    'errorAction' => 'tad/index/error',
                ],
                'user'         => [
                    'class'           => 'CWebUser',
                    'allowAutoLogin'  => true,
                    'stateKeyPrefix'  => 'tab',
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
                Yii::app()->user->login($identity);
            }
        }
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
