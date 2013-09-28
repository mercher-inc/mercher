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

        $criteria = new \CDbCriteria;

        $criteria->condition = 't.is_active = TRUE AND t.is_banned = FALSE';
        if ($category_id) {
            $criteria->condition .= ' AND t.category_id = :categoryId';
            $criteria->params    = array('categoryId' => (int)$category_id);
        }

        $result['count'] = (int)$shop->productsCount(
            $criteria
        );

        $criteria->offset = $offset;
        $criteria->limit = $limit;
        $criteria->condition = 'products.is_active = TRUE AND products.is_banned = FALSE';

        if ($category_id) {
            $criteria->condition .= ' AND products.category_id = :categoryId';
            $criteria->params    = array('categoryId' => (int)$category_id);
        }

        $criteria->with  = array('category', 'image');
        $criteria->order = 'products.created DESC';

        $products = $shop->products(
            $criteria
        );

        if (count($products)) {
            foreach ($products as $product) {
                $model             = $product->attributes;
                $model['category'] = $product->category ? $product->category->attributes : null;

                unset($model['image_id']);
                $model['image'] = array();
                if ($product->image) {
                    $image = $product->image->attributes;
                    try {
                        $model['image'] = \CJSON::decode($image['data']);
                    } catch (\Exception $e) {
                    }
                }
                $result['models'][] = $model;
            }
        }
        echo \CJSON::encode($result);
    }

    public function actionRead($shop_id, $product_id)
    {
        $shop   = \Shop::model()->findByPk($shop_id);
        if (!$shop) {
            throw new \CHttpException(404, \Yii::t('error', 'shop_not_found'));
        }
        $criteria = new \CDbCriteria;
        $criteria->condition = 'products.is_active = TRUE AND products.is_banned = FALSE AND products.id = :productId';
        $criteria->params    = array('productId' => (int)$product_id);
        $criteria->with  = array('category', 'image');
        $products = $shop->products(
            $criteria
        );
        if (!count($products)) {
            throw new \CHttpException(404, \Yii::t('error', 'product_not_found'));
        }
        $product = $products[0];

        $model             = $product->attributes;
        $model['category'] = $product->category ? $product->category->attributes : null;

        unset($model['image_id']);
        $model['image'] = array();
        if ($product->image) {
            $image = $product->image->attributes;
            try {
                $model['image'] = \CJSON::decode($image['data']);
            } catch (\Exception $e) {
            }
        }
        echo \CJSON::encode($model);
    }
}