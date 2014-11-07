<?php
/**
 * Created by JetBrains PhpStorm.
 * Project: mercher
 * Author: dmitry
 * Date: 9/9/13
 * Time: 4:33 PM
 */

namespace export\controllers;


class ProductsController extends \Controller
{
    public $password = '4f3969cdb80a752c372e2dbcd30f163431b6f587';

    public function actionList($password)
    {
        if ($password != $this->$password) {
            throw new \CHttpException(403, 'Wrong password');
        }

        $result = array();

        $products   = \Product::model()->findAll();

        if (count($products)) {
            foreach ($products as $product) {
                $model             = $product->attributes;

                unset($model['image_id']);
                $model['image'] = array();
                if ($product->image) {
                    $image = $product->image->attributes;
                    try {
                        $model['image'] = \CJSON::decode($image['data']);
                    } catch (\Exception $e) {
                    }
                }
                $result[] = $model;
            }
        }
        echo \CJSON::encode($result);
    }
}
