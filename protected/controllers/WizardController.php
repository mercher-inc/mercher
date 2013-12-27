<?php
/**
 * Project: mercher
 * Author: Dmitry Les
 * Date: 11/1/13
 * Time: 4:38 PM
 */

class WizardController extends Controller
{
    protected $_user;
    protected $_shop;

    public $defaultAction = 'step1';
    public $layout = '//layouts/wizard';

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
                    'step1',
                    'step2',
                    'step3',
                    'step4'
                ),
                'users'   => array('@'),
            ),
            array(
                'deny',
                'users' => array('*'),
            ),
        );
    }

    public function actionStep1()
    {
        if (count($this->user->shops) == 1) {
            $this->redirect(Yii::app()->urlManager->createUrl('wizard/step2'));
        } elseif (count($this->user->shops) > 1) {
            $this->redirect(Yii::app()->urlManager->createUrl('shops/index'));
        }

        $model = new Shop;

        if (isset($_POST['Shop'])) {
            $model->attributes = $_POST['Shop'];

            if ($model->save()) {
                $this->redirect(Yii::app()->urlManager->createUrl('wizard/step2'));
            }
        }

        $accounts = [];
        try {
            $result = Yii::app()->facebook->sdk->api('/me/accounts?fields=id,name&limit=50');
        } catch (FacebookApiException $e) {
            throw new CHttpException(500, $e->getMessage(), $e->getCode());
        }
        if (isset($result['data'])) {
            foreach ($result['data'] as $row) {
                $accounts[$row['id']] = $row['name'];
            }
        }

        $this->render(
            'step1',
            [
                'model'    => $model,
                'accounts' => $accounts
            ]
        );
    }

    public function actionStep2()
    {
        if (count($this->user->shops) < 1) {
            $this->redirect(Yii::app()->urlManager->createUrl('wizard/step1'));
        } elseif (count($this->user->shops) > 1) {
            $this->redirect(Yii::app()->urlManager->createUrl('shops/index'));
        }

        $shop = Shop::model()->findByAttributes(['owner_id' => $this->user->id]);

        if (count($shop->products) == 1) {
            $this->redirect(Yii::app()->urlManager->createUrl('wizard/step3'));
        } elseif (count($shop->products) > 1) {
            $this->redirect(Yii::app()->urlManager->createUrl('shops/index'));
        }

        $model          = new Product;
        $model->shop_id = $shop->id;

        if (isset($_POST['Product'])) {
            $model->attributes = $_POST['Product'];
            $model->shop_id    = $shop->id;

            if ($model->save()) {
                $this->redirect(Yii::app()->urlManager->createUrl('wizard/step2'));
            }
        }

        $this->render(
            'step2',
            [
                'model'          => $model,
                'shop'           => $shop
            ]
        );
    }

    public function actionStep3()
    {
        if (count($this->user->shops) < 1) {
            $this->redirect(Yii::app()->urlManager->createUrl('wizard/step1'));
        } elseif (count($this->user->shops) > 1) {
            $this->redirect(Yii::app()->urlManager->createUrl('shops/index'));
        }

        $model = Shop::model()->findByAttributes(['owner_id' => $this->user->id]);

        if (isset($_POST['Shop'])) {
            $model->attributes = $_POST['Shop'];

            if ($model->save()) {
                $this->redirect(Yii::app()->urlManager->createUrl('shops/index'));
            }
        }

        $this->render(
            'step4',
            [
                'model'           => $model
            ]
        );

    }

    public function getUser()
    {
        if (!$this->_user) {
            $this->_user = User::model()->findByPk(Yii::app()->user->id);
            if (!$this->_user) {
                $this->redirect(Yii::app()->urlManager->createUrl('index/index'));
            }
        }
        return $this->_user;
    }
}