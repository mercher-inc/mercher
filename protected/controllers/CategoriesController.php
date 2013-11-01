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
                'categories' => $this->shop->categories
            )
        );
    }

    public function actionCreate()
    {
        $this->category = new Category;

        if (Yii::app()->request->isPostRequest) {
            $this->category->attributes = $_POST;
            $this->category->shop_id = $this->shop->id;

            if ($this->category->save()) {
                $this->category->refresh();
                $this->redirect(Yii::app()->urlManager->createUrl('categories/index', array('shop_id'=>$this->shop->id)));
            }
        }

        //var_dump($this->shop);

        $this->render(
            'create',
            array(
                'category' => $this->category
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
            $this->category->attributes = $_POST;

            if ($this->category->save()) {
                $this->category->refresh();
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

    public function getCategory()
    {
        if (!$this->_category) {
            $this->_category = Category::model()->findByPk(Yii::app()->request->getParam('category_id'));
            if (!$this->_category) {
                throw new CHttpException(404);
            }
            if ($this->_category->shop_id != $this->shop->id) {
                throw new CHttpException(401);
            }
        }
        return $this->_category;
    }

    public function setCategory(Category $category)
    {
        $this->_category = $category;
    }
}