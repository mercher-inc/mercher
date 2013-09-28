<?php

class IndexController extends CController
{
    public $pageId;
    public $isAdmin;
    public $country;
    public $locale;
    public $age;
    public $data;

    public $shop;

	public function actionIndex()
	{
        $this->shop = Shop::model()->find('fb_id = :pageId', array('pageId' => $this->pageId));

        if (!$this->shop or !$this->shop->is_active or $this->shop->is_banned) {
            $this->render('error');
            return;
        }

        \Yii::app()->clientScript->registerScript(
            'appConfig.requestData',
            'appConfig.requestData = ' . \CJSON::encode($this->data) . ";\n",
            \CClientScript::POS_HEAD
        );

		$this->render('index');
	}
}