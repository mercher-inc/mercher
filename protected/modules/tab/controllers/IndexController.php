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

        //var_dump($this->shop, $this);

		$this->render('index');
	}
}