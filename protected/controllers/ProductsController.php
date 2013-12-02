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
        if ($this->shop->productsCount >= $this->shop->maxProductsCount) {
            throw new CHttpException(402, Yii::t('product', 'too_many'));
        }

        $this->product = new Product;

        if (isset($_POST['Product'])) {
            $this->product->attributes = $_POST['Product'];
            $this->product->new_image  = CUploadedFile::getInstanceByName('Product[new_image]');
            $this->product->shop_id    = $this->shop->id;

            if ($this->product->save()) {
                Yii::app()->user->setFlash(
                    'Product',
                    Yii::t(
                        'product',
                        'create_success',
                        [
                            '{view}' => CHtml::link(
                                Yii::t('product', 'view_online'),
                                '//www.facebook.com/' .
                                    $this->shop->fb_id .
                                    '?'
                                    . http_build_query(
                                    array(
                                        'sk'       => 'app_' . Yii::app()->facebook->sdk->getAppId(),
                                        'app_data' => CJSON::encode(
                                            array(
                                                'product_id' => $this->product->id
                                            )
                                        )
                                    )
                                ),
                                [
                                    'class'  => 'alert-link',
                                    'target' => '_blank'
                                ]
                            )
                        ]
                    )
                );
                $this->redirect(
                    Yii::app()->urlManager->createUrl(
                        'products/update',
                        array(
                            'shop_id'    => $this->shop->id,
                            'product_id' => $this->product->id
                        )
                    )
                );
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
            $this->product->new_image  = CUploadedFile::getInstanceByName('Product[new_image]');

            if ($this->product->save()) {
                Yii::app()->user->setFlash(
                    'Product',
                    Yii::t(
                        'product',
                        'save_success',
                        [
                            '{view}' => CHtml::link(
                                Yii::t('product', 'view_online'),
                                '//www.facebook.com/' .
                                    $this->shop->fb_id .
                                    '?'
                                    . http_build_query(
                                    array(
                                        'sk'       => 'app_' . Yii::app()->facebook->sdk->getAppId(),
                                        'app_data' => CJSON::encode(
                                            array(
                                                'product_id' => $this->product->id
                                            )
                                        )
                                    )
                                ),
                                [
                                    'class'  => 'alert-link',
                                    'target' => '_blank'
                                ]
                            )
                        ]
                    )
                );
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