<?php
/**
 * Created by JetBrains PhpStorm.
 * Project: mercher
 * Author: dmitry
 * Date: 9/23/13
 * Time: 2:19 PM
 */

class DesignController extends Controller
{
    public $layout = '//layouts/shop';

    protected $_shop;

    public function actionIndex()
    {
        if (Yii::app()->request->isPostRequest) {
            $this->shop->templateInstance->processForm();
        }
        $this->render('index');
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