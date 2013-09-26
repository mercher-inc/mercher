<?php
/**
 * Created by JetBrains PhpStorm.
 * Project: mercher
 * Author: dmitry
 * Date: 9/9/13
 * Time: 4:33 PM
 */

namespace api\controllers;


class ProductsController extends \Controller
{
    public function actionList($shop_id, $category_id = null, $offset = 0, $limit = 10)
    {
        $offset = (int)$offset;
        $limit  = (int)$limit;

        $result = array(
            'models' => array(),
            'count'  => 0,
            'offset' => $offset,
            'limit'  => $limit,
        );
        $shop   = \Shop::model()->findByPk($shop_id);
        if (!$shop) {
            throw new \CHttpException(404, \Yii::t('error', 'shop_not_found'));
        }
        if (!$category_id) {
            $result['count'] = (int)$shop->productsCount;
            $products        = $shop->products;
        } else {
            $result['count'] = (int)$shop->productsCount(
                'category_id = :categoryId',
                array('categoryId' => (int)$category_id)
            );
            $products        = $shop->products(
                'category_id = :categoryId',
                array('categoryId' => (int)$category_id)
            );
        }
        if (count($products)) {
            foreach ($products as $product) {
                $result['models'][] = $product->attributes;
            }
        }
        echo \CJSON::encode($result);
    }
}