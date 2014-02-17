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
                'actions' => array('index'),
                'roles'   => array(
                    AuthManager::PERMISSION_READ_PRODUCT => array(
                        'shop_id' => Yii::app()->request->getParam('shop_id'),
                    )
                )
            ),
            array(
                'allow',
                'actions' => array('create'),
                'roles'   => array(
                    AuthManager::PERMISSION_CREATE_PRODUCT => array(
                        'shop_id' => Yii::app()->request->getParam('shop_id')
                    )
                )
            ),
            array(
                'allow',
                'actions' => array('read'),
                'roles'   => array(
                    AuthManager::PERMISSION_READ_PRODUCT => array(
                        'shop_id'    => Yii::app()->request->getParam('shop_id'),
                        'product_id' => Yii::app()->request->getParam('product_id'),
                    )
                )
            ),
            array(
                'allow',
                'actions' => array('update'),
                'roles'   => array(
                    AuthManager::PERMISSION_UPDATE_PRODUCT => array(
                        'shop_id'    => Yii::app()->request->getParam('shop_id'),
                        'product_id' => Yii::app()->request->getParam('product_id'),
                    )
                )
            ),
            array(
                'allow',
                'actions' => array('delete'),
                'roles'   => array(
                    AuthManager::PERMISSION_DELETE_PRODUCT => array(
                        'shop_id'    => Yii::app()->request->getParam('shop_id'),
                        'product_id' => Yii::app()->request->getParam('product_id'),
                    )
                )
            ),
            array(
                'deny',
                'users' => array('*'),
            ),
        );
    }

    public function actionIndex()
    {
        $model = new Product('search');
        $model->unsetAttributes();
        $model->getDbCriteria()->order = 'created DESC';

        if (isset($_GET['Product'])) {
            $model->attributes = $_GET['Product'];
        }

        $model->shop_id = $this->shop->id;

        $this->render(
            'index',
            array(
                'model' => $model,
            )
        );
    }

    public function actionCreate()
    {
        $this->product          = new Product;
        $this->product->shop_id = $this->shop->id;

        if (isset($_POST['Product'])) {
            $this->product->attributes = $_POST['Product'];
            $this->product->shop_id    = $this->shop->id;

            if ($this->product->save()) {
                $this->redirect(['index', 'shop_id' => $this->shop->id]);
            }
        }

        $categories     = $this->shop->categories;
        $categoriesList = ['' => 'Not set'];
        if (count($categories)) {
            foreach ($categories as $c) {
                $categoriesList[$c->id] = $c->title;
            }
        }

        $this->render(
            'create',
            array(
                'shop'           => $this->shop,
                'model'          => $this->product,
                'categoriesList' => $categoriesList
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

            if ($this->product->save()) {
                $this->redirect(['index', 'shop_id' => $this->shop->id]);
            }
        }

        $categories     = $this->shop->categories;
        $categoriesList = ['' => 'Not set'];
        if (count($categories)) {
            foreach ($categories as $c) {
                $categoriesList[$c->id] = $c->title;
            }
        }

        $this->render(
            'update',
            array(
                'shop'           => $this->shop,
                'model'          => $this->product,
                'categoriesList' => $categoriesList
            )
        );
    }

    public function actionDelete()
    {
        if (Yii::app()->request->isDeleteRequest) {
            $this->product->delete();
            $this->redirect(['index', 'shop_id' => $this->shop->id]);
        }
        if (!$this->product->orderItemsCount) {
            $this->render(
                'delete',
                array(
                    'shop'  => $this->shop,
                    'model' => $this->product
                )
            );
        } else {
            $this->render(
                'deleteError',
                array(
                    'shop'  => $this->shop,
                    'model' => $this->product
                )
            );
        }
    }

    public function getShop()
    {
        if (!$this->_shop) {
            $this->_shop = Shop::model()->findByPk(Yii::app()->request->getParam('shop_id'));
            if (!$this->_shop) {
                throw new CHttpException(404);
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
        }
        return $this->_product;
    }

    public function setProduct(Product $product)
    {
        $this->_product = $product;
    }
}