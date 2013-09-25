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
            $controller->layout = 'main';

            $data = Yii::app()->facebook->sdk->getSignedRequest();

            if (isset($data['page'])) {
                if (isset($data['page']['id'])) {
                    $controller->pageId = $data['page']['id'];
                }
                if (isset($data['page']['admin']) and $data['page']['admin'] == true) {
                    $controller->isAdmin = true;
                }
            }

            if (isset($data['user'])) {
                if (isset($data['user']['country'])) {
                    $controller->country = $data['user']['country'];
                }
                if (isset($data['user']['locale'])) {
                    $controller->locale = $data['user']['locale'];
                }
                if (isset($data['user']['age']) and isset($data['user']['age']['min'])) {
                    $controller->age = $data['user']['age']['min'];
                }
            }

            if (isset($data['app_data'])) {
                try {
                    $controller->data = CJSON::decode($data['app_data']);
                } catch (Exception $e) {

                }
            }
			// this method is called before any module controller action is performed
			// you may place customized code here
			return true;
		}
		else
			return false;
	}
}
