<?php
/**
 * Project: mercher
 * Author: Dmitry Les
 * Date: 12/18/13
 * Time: 2:29 PM
 */

class SubscriptionController extends Controller
{

    public function actionIndex()
    {
        Yii::app()->clientScript->registerScript(
            'create_subscription',
            "
                var obj = {
                    method: 'pay',
                    action: 'create_subscription',
                    product: 'http://mercher.net/og/subscription/313.html'
                };
                FB.ui(obj, function(r){
                    console.log(r);
                });
            ",
            ClientScript::POS_FB
        );
        $this->render('index');
    }

}