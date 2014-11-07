<?php
/**
 * Created by JetBrains PhpStorm.
 * Project: mercher
 * Author: dmitry
 * Date: 9/9/13
 * Time: 4:33 PM
 */

namespace export\controllers;


class ShopsController extends \Controller
{
    public function actionList($password)
    {
        if ($password != '4f3969cdb80a752c372e2dbcd30f163431b6f587') {
            throw new \CHttpException(403, 'Wrong password');
        }

        $result = array();

        $shops   = \Shop::model()->findAll();

        if (count($shops)) {
            foreach ($shops as $shop) {
                $model             = $shop->attributes;

                unset($model['image_id']);
                $model['image'] = array();
                if ($shop->image) {
                    $image = $shop->image->attributes;
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
