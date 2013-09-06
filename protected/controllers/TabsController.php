<?php
/**
 * Created by JetBrains PhpStorm.
 * Project: mercher
 * Author: dmitry
 * Date: 9/4/13
 * Time: 6:57 PM
 */

class TabsController extends Controller
{
    public function actionIndex()
    {
        $this->render('index');
    }

    public function actionGet($tab_id)
    {
        $product = new Products();
        $product->model = 'New product';
        $product->shop_id = 2;

        if (!$product->save()) {
            var_dump($product->getErrors());
        }
        var_dump($product);


        $this->render('get');
    }
}