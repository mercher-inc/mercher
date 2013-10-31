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
        $shops = $user->shops(['limit'=>1, 'order'=>'created']);

        if (count($shops)) {
            $this->redirect(Yii::app()->urlManager->createUrl('products/index', ['shop_id'=>$shops[0]->id]));
        } else {
            $this->redirect(Yii::app()->urlManager->createUrl('shops/create'));
        }
    }

    public function actionCreate()
    {
        $this->shop = new Shop;

        if (Yii::app()->request->isPostRequest) {
            $this->shop->attributes = $_POST;

            if ($this->shop->save()) {
                $this->shop->refresh();
                $this->redirect(Yii::app()->urlManager->createUrl('shops/read', array('shop_id'=>$this->shop->id)));
            }
        }

        //var_dump($this->shop);

        $this->render(
            'create',
            array(
                'shop' => $this->shop
            )
        );
    }

    public function actionUpdate()
    {
        $this->layout = '//layouts/shop';

        if (Yii::app()->request->isPostRequest) {
            $this->shop->attributes = $_POST;

            if ($this->shop->save()) {
                $this->shop->refresh();
            }
        }

        $this->render(
            'update',
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

    public function setShop(Shop $shop)
    {
        $this->_shop = $shop;
    }
}