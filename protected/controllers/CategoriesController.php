<?php
/**
 * Created by JetBrains PhpStorm.
 * Project: mercher
 * Author: dmitry
 * Date: 9/9/13
 * Time: 1:12 PM
 */

class CategoriesController extends Controller
{
    public $layout='//layouts/shop';

    protected $_shop;

    public function actionIndex()
    {
        $this->render('index');
    }

    public function actionGet()
    {
        $this->render('get');
    }

    public function getShop() {
        if ($this->_shop === null) {
            $this->_shop = Shops::model()->findByPk(Yii::app()->request->getParam('shop_id'));
        }
        return $this->_shop;
    }
}