<?php
/**
 * Created by JetBrains PhpStorm.
 * Project: mercher
 * Author: dmitry
 * Date: 9/26/13
 * Time: 6:07 PM
 */

namespace api\controllers;


class CategoriesController extends \CController
{
    public function actionList($shop_id, $offset = 0, $limit = 10)
    {
        $offset = (int) $offset;
        $limit = (int) $limit;

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
        $result['count'] = (int) $shop->categoriesCount;
        $categories = $shop->categories;
        if (count($categories)) {
            foreach ($categories as $category) {
                $result['models'][] = $category->attributes;
            }
        }
        echo \CJSON::encode($result);
    }

    public function actionRead($shop_id, $category_id)
    {
        //var_dump(__METHOD__);
    }
}