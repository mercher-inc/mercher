<?php
/**
 * Created by JetBrains PhpStorm.
 * Project: mercher
 * Author: dmitry
 * Date: 9/6/13
 * Time: 7:18 PM
 */

class OgProductBehavior extends CActiveRecordBehavior
{
    public function beforeSave(CModelEvent $event)
    {
        $model = $this->getOwner();

        $ch     = curl_init();
        $object = array(
            'og:title' => $model->title
        );
        if ($model->plural_title) {
            $object['product:plural_title'] = $model->plural_title;
        }
        if ($model->brand) {
            $object['og:title'] = $model->brand . ' ' . $object['og:title'];
            $object['product:brand'] = $model->brand;
        }
        if ($model->price) {
            $object['product:price:amount']   = $model->price;
            $object['product:price:currency'] = 'USD';
        }
        if ($model->description) {
            $object['og:description']   = $model->description;
        }

        $category = $model->category;
        if ($category) {
            $object['product:category']   = $category->title;
        }

        $object['og:url']   = 'http://www.facebook.com/'.$model->shop_id.'?sk=app_' . Yii::app()->facebook->sdk->getAppId();

        $accessToken = Yii::app()->facebook->sdk->getAppId() . '|' . Yii::app()->facebook->sdk->getAppSecret();
        $opts        = array(
            CURLOPT_CONNECTTIMEOUT => 10,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_TIMEOUT        => 60,
            CURLOPT_POSTFIELDS     => http_build_query(
                array(
                    'access_token' => $accessToken,
                    'object'       => CJSON::encode($object)
                )
            ),
            CURLOPT_POST           => 1
        );

        if ($model->isNewRecord) {
            $opts[CURLOPT_URL] = 'https://graph.facebook.com/app/objects/product';
            curl_setopt_array($ch, $opts);
            $result    = CJSON::decode(curl_exec($ch));
            $model->id = $result['id'];
            return true;
        } else {
            $opts[CURLOPT_URL] = 'https://graph.facebook.com/' . $model->id;
            curl_setopt_array($ch, $opts);
            curl_exec($ch);
            return true;
        }
    }
}