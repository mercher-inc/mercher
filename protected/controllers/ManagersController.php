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
                'actions' => array(
                    'index',
                    'create',
                    'read',
                    'update',
                    'delete'
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
            if (Yii::app()->user->id != $this->_shop->owner_id) {
                throw new CHttpException(401);
            }
        }
        return $this->_shop;
    }
}