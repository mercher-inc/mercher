<?php
/**
 * Created by JetBrains PhpStorm.
 * Project: mercher
 * Author: dmitry
 * Date: 9/9/13
 * Time: 1:11 PM
 */

class ProductsController extends Controller
{
    public $layout='//layouts/shop';

    protected $_shop;
    protected $_product;

    public function actionIndex()
    {
        $this->render(
            'index',
            array(
                'products' => $this->shop->with('category')->products
            )
        );
    }

    public function actionCreate()
    {
        $this->product = new Product;

        if (Yii::app()->request->isPostRequest) {
            $this->product->attributes = $_POST;
            $this->product->shop_id = $this->shop->id;

            if ($this->product->save()) {
                $this->product->refresh();
                $this->redirect(Yii::app()->urlManager->createUrl('products/read', array('shop_id'=>$this->shop->id, 'product_id'=>$this->product->id)));
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

    public function actionRead()
    {
        $this->render('read');
    }

    public function actionUpdate()
    {
        if (Yii::app()->request->isPostRequest) {
            $this->product->attributes = $_POST;

            if ($this->product->save()) {
                $this->product->refresh();
            }
        }

        $this->render('update');
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

    public function getProduct()
    {
        if (!$this->_product) {
            $this->_product = Product::model()->findByPk(Yii::app()->request->getParam('product_id'));
            if (!$this->_product) {
                throw new CHttpException(404);
            }
            if ($this->_product->shop_id != $this->shop->id) {
                throw new CHttpException(401);
            }
        }
        return $this->_product;
    }

    public function setProduct(Product $product)
    {
        $this->_product = $product;
    }
}