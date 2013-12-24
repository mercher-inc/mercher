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
    protected $_category;

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
                    AuthManager::PERMISSION_READ_CATEGORY => array(
                        'shop_id'    => Yii::app()->request->getParam('shop_id'),
                    )
                )
            ),
            array(
                'allow',
                'actions' => array('create'),
                'roles'   => array(
                    AuthManager::PERMISSION_CREATE_CATEGORY => array(
                        'shop_id' => Yii::app()->request->getParam('shop_id')
                    )
                )
            ),
            array(
                'allow',
                'actions' => array('read'),
                'roles'   => array(
                    AuthManager::PERMISSION_READ_CATEGORY => array(
                        'shop_id'    => Yii::app()->request->getParam('shop_id'),
                        'category_id' => Yii::app()->request->getParam('category_id'),
                    )
                )
            ),
            array(
                'allow',
                'actions' => array('update'),
                'roles'   => array(
                    AuthManager::PERMISSION_UPDATE_CATEGORY => array(
                        'shop_id'    => Yii::app()->request->getParam('shop_id'),
                        'category_id' => Yii::app()->request->getParam('category_id'),
                    )
                )
            ),
            array(
                'allow',
                'actions' => array('delete'),
                'roles'   => array(
                    AuthManager::PERMISSION_DELETE_CATEGORY => array(
                        'shop_id'    => Yii::app()->request->getParam('shop_id'),
                        'category_id' => Yii::app()->request->getParam('category_id'),
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
        $model = new Category('search');
        $model->unsetAttributes();

        if (isset($_GET['Category'])) {
            $model->attributes = $_GET['Category'];
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
        if ($this->shop->categoriesCount >= $this->shop->maxProductsCount) {
            throw new CHttpException(402, Yii::t('category', 'too_many'));
        }

        $this->category = new Category;

        if (isset($_POST['Category'])) {
            $this->category->attributes = $_POST['Category'];
            $this->category->shop_id    = $this->shop->id;

            if ($this->category->save()) {
                $this->redirect(['index', 'shop_id' => $this->shop->id]);
            }
        }

        //var_dump($this->shop);

        $this->render(
            'create',
            array(
                'shop'  => $this->shop,
                'model' => $this->category,
            )
        );
    }

    public function actionRead()
    {
        $this->render('read');
    }

    public function actionUpdate()
    {
        if (isset($_POST['Category'])) {
            $this->category->attributes = $_POST['Category'];

            if ($this->category->save()) {
                $this->redirect(['index', 'shop_id' => $this->shop->id]);
            }
        }

        $this->render(
            'update',
            array(
                'shop'  => $this->shop,
                'model' => $this->category,
            )
        );
    }

    public function actionDelete()
    {
        if (Yii::app()->request->isDeleteRequest) {
            $this->category->delete();
            $this->redirect(['index', 'shop_id' => $this->shop->id]);
        }
        $this->render(
            'delete',
            array(
                'shop'  => $this->shop,
                'model' => $this->category
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
        }
        return $this->_shop;
    }

    public function getCategory()
    {
        if (!$this->_category) {
            $this->_category = Category::model()->findByPk(Yii::app()->request->getParam('category_id'));
            if (!$this->_category) {
                throw new CHttpException(404);
            }
        }
        return $this->_category;
    }

    public function setCategory(Category $category)
    {
        $this->_category = $category;
    }
}