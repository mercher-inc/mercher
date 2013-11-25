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

        if (count($shop->categories) == 1) {
            $this->redirect(Yii::app()->urlManager->createUrl('wizard/step3'));
        } elseif (count($shop->categories) > 1) {
            $this->redirect(Yii::app()->urlManager->createUrl('shops/index'));
        }

        $model = new Category;

        if (isset($_POST['Category'])) {
            $model->attributes = $_POST['Category'];
            $model->shop_id    = $shop->id;

            if ($model->save()) {
                $this->redirect(Yii::app()->urlManager->createUrl('wizard/step3'));
            }
        }

        $this->render('step2', ['model' => $model]);
    }

    public function actionStep3()
    {
        if (count($this->user->shops) < 1) {
            $this->redirect(Yii::app()->urlManager->createUrl('wizard/step1'));
        } elseif (count($this->user->shops) > 1) {
            $this->redirect(Yii::app()->urlManager->createUrl('shops/index'));
        }

        $shop = Shop::model()->findByAttributes(['owner_id' => $this->user->id]);

        $categories = $shop->categories;
        $category   = null;

        if (count($shop->products) == 1) {
            $this->redirect(Yii::app()->urlManager->createUrl('wizard/step4'));
        } elseif (count($shop->products) > 1) {
            $this->redirect(Yii::app()->urlManager->createUrl('shops/index'));
        }

        $model = new Product;

        $categoriesList = ['' => 'Not set'];
        if (count($categories)) {
            $category           = $categories[0];
            $model->category_id = $category->id;

            foreach ($categories as $c) {
                $categoriesList[$c->id] = $c->title;
            }
        }

        if (isset($_POST['Product'])) {
            $model->attributes = $_POST['Product'];
            $model->new_image  = CUploadedFile::getInstanceByName('Product[new_image]');
            $model->shop_id    = $shop->id;

            if ($model->save()) {
                $this->redirect(Yii::app()->urlManager->createUrl('wizard/step3'));
            }
        }

        $this->render(
            'step3',
            [
                'model'          => $model,
                'shop'           => $shop,
                'category'       => $category,
                'categoriesList' => $categoriesList
            ]
        );
    }

    public function actionStep4()
    {
        if (count($this->user->shops) < 1) {
            $this->redirect(Yii::app()->urlManager->createUrl('wizard/step1'));
        }

        $shop = Shop::model()->findByAttributes(['owner_id' => $this->user->id]);

        if (count($shop->products) < 1) {
            $this->redirect(Yii::app()->urlManager->createUrl('wizard/step4'));
        }

        $this->redirect(Yii::app()->urlManager->createUrl('shops/index'));
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