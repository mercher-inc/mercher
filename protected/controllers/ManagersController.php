<?php
/**
 * Project: mercher
 * Author: Dmitry Les
 * Date: 12/23/13
 * Time: 7:32 PM
 */

class ManagersController extends Controller
{
    public $layout = '//layouts/shop';

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
                    AuthManager::PERMISSION_READ_MANAGER => array(
                        'shop_id'    => Yii::app()->request->getParam('shop_id'),
                    )
                )
            ),
            array(
                'allow',
                'actions' => array('create'),
                'roles'   => array(
                    AuthManager::PERMISSION_CREATE_MANAGER => array(
                        'shop_id' => Yii::app()->request->getParam('shop_id')
                    )
                )
            ),
            array(
                'allow',
                'actions' => array('read'),
                'roles'   => array(
                    AuthManager::PERMISSION_READ_MANAGER => array(
                        'shop_id'    => Yii::app()->request->getParam('shop_id'),
                        'user_id' => Yii::app()->request->getParam('user_id'),
                    )
                )
            ),
            array(
                'allow',
                'actions' => array('update'),
                'roles'   => array(
                    AuthManager::PERMISSION_UPDATE_MANAGER => array(
                        'shop_id'    => Yii::app()->request->getParam('shop_id'),
                        'user_id' => Yii::app()->request->getParam('user_id'),
                    )
                )
            ),
            array(
                'allow',
                'actions' => array('delete'),
                'roles'   => array(
                    AuthManager::PERMISSION_DELETE_MANAGER => array(
                        'shop_id'    => Yii::app()->request->getParam('shop_id'),
                        'user_id' => Yii::app()->request->getParam('user_id'),
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
        $model = new Manager('search');
        $model->unsetAttributes();

        if (isset($_GET['Manager'])) {
            $model->attributes = $_GET['Manager'];
        }
        $model->shop_id = $this->shop->id;

        $this->render(
            'index',
            array(
                'model' => $model,
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
}