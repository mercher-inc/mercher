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
                    AuthManager::PERMISSION_READ_SHOP
                )
            ),
            array(
                'allow',
                'actions' => array('create'),
                'roles'   => array(
                    AuthManager::PERMISSION_CREATE_SHOP
                )
            ),
            array(
                'allow',
                'actions' => array('read'),
                'roles'   => array(
                    AuthManager::PERMISSION_READ_SHOP => array(
                        'shop_id'    => Yii::app()->request->getParam('shop_id'),
                    )
                )
            ),
            array(
                'allow',
                'actions' => array('update'),
                'roles'   => array(
                    AuthManager::PERMISSION_UPDATE_SHOP => array(
                        'shop_id'    => Yii::app()->request->getParam('shop_id'),
                    )
                )
            ),
            array(
                'allow',
                'actions' => array('delete'),
                'roles'   => array(
                    AuthManager::PERMISSION_DELETE_SHOP => array(
                        'shop_id'    => Yii::app()->request->getParam('shop_id'),
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
        $user  = User::model()->findByPk(Yii::app()->user->id);
        $shops = $user->shops(['limit' => 1, 'order' => 'created']);

        if (count($shops)) {
            $this->redirect(Yii::app()->urlManager->createUrl('products/index', ['shop_id' => $shops[0]->id]));
        } else {
            $this->redirect(Yii::app()->urlManager->createUrl('wizard'));
        }
    }

    public function actionCreate()
    {
        $this->shop = new Shop;

        if (Yii::app()->request->isPostRequest) {
            $this->shop->attributes = $_POST;

            if ($this->shop->save()) {
                $this->shop->refresh();
                $this->redirect(Yii::app()->urlManager->createUrl('shops/index'));
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

        if (isset($_POST['Shop'])) {
            $this->shop->attributes = $_POST['Shop'];

            if ($this->shop->save()) {
                $this->redirect(['index']);
            }
        }

        $this->render(
            'update',
            array(
                'model' => $this->shop,
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

    public function setShop(Shop $shop)
    {
        $this->_shop = $shop;
    }
}