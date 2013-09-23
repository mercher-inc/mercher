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
    public $layout = '//layouts/shop';

    protected $_shop;

    public function actionIndex()
    {
        $this->render(
            'index',
            array(
                'categories' => $this->shop->categories
            )
        );
    }

    public function actionGet()
    {
        $this->render('get');
    }

    public function getShop()
    {
        if (!$this->_shop) {
            $this->_shop = Shop::model()->findByPk(Yii::app()->request->getParam('shop_id'));
            if (!$this->_shop) {
                throw new CHttpException(404);
            }
            if (Yii::app()->user->id != $this->_shop->owner_id) {
                throw new CHttpException(401);
            }
        }
        return $this->_shop;
    }
}