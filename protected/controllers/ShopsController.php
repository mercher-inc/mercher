<?php
/**
 * Created by JetBrains PhpStorm.
 * Project: mercher
 * Author: dmitry
 * Date: 9/5/13
 * Time: 1:40 PM
 */

class ShopsController extends Controller
{
    protected $_shop;

    public function actionIndex()
    {
        $user  = User::model()->findByPk(Yii::app()->user->id);
        $shops = $user->shops;
        $this->render(
            'index',
            array(
                'shops' => $shops
            )
        );
    }

    public function actionCreate()
    {
        $this->layout = '//layouts/shop';
        $this->render('create');
    }

    public function actionRead()
    {
        $this->layout = '//layouts/shop';
        $this->render(
            'read',
            array(
                'shop' => $this->shop
            )
        );
    }

    public function actionUpdate()
    {
        $this->layout = '//layouts/shop';
        $this->render(
            'update',
            array(
                'shop' => $this->shop
            )
        );
    }

    public function actionDelete()
    {
        $this->layout = '//layouts/shop';
        $this->render(
            'delete',
            array(
                'shop' => $this->shop
            )
        );
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