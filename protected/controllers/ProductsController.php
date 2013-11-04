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
    public $layout = '//layouts/shop';

    protected $_shop;
    protected $_product;

    public function filters()
    {
        return array(
            'accessControl',
        );
    }

    public function accessRules()
    {
        return array(
            array(
                'allow',
                'actions' => array(
                    'index',
                    'create',
                    'read',
                    'update'
                ),
                'users'   => array('@'),
            ),
            array(
                'deny',
                'users' => array('*'),
            ),
        );
    }

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

        if (isset($_POST['Product'])) {
            $this->product->attributes = $_POST['Product'];
            $this->product->new_image  = CUploadedFile::getInstanceByName('Product[new_image]');
            $this->product->shop_id    = $this->shop->id;

            if ($this->product->save()) {
                $this->product->refresh();
                $this->redirect(
                    Yii::app()->urlManager->createUrl(
                        'products/index',
                        array('shop_id' => $this->shop->id)
                    )
                );
            }
        }

        $categories = $this->shop->categories;
        $categoriesList = ['' => 'Not set'];
        if (count($categories)) {
            foreach ($categories as $c) {
                $categoriesList[$c->id] = $c->title;
            }
        }

        $this->render(
            'create',
            array(
                'shop'  => $this->shop,
                'model' => $this->product,
                'categoriesList'   =>  $categoriesList
            )
        );
    }

    public function actionRead()
    {
        $this->render('read');
    }

    public function actionUpdate()
    {
        if (isset($_POST['Product'])) {
            $this->product->attributes = $_POST['Product'];
            $this->product->new_image  = CUploadedFile::getInstanceByName('Product[new_image]');

            if ($this->product->save()) {
                $this->product->refresh();
            }
        }

        $categories = $this->shop->categories;
        $categoriesList = ['' => 'Not set'];
        if (count($categories)) {
            foreach ($categories as $c) {
                $categoriesList[$c->id] = $c->title;
            }
        }

        $this->render(
            'update',
            array(
                'shop'  => $this->shop,
                'model' => $this->product,
                'categoriesList'   =>  $categoriesList
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