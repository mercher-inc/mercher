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
    public function actionIndex()
    {
        $user = User::model()->findByPk(Yii::app()->user->id);
        $shops = $user->shops;
        $this->render(
            'index',
            array(
                'shops' => $shops
            )
        );
    }

    public function actionGet()
    {
        $this->render('get');
    }
}