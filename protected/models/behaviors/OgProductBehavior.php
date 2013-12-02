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
        if ($model->amount) {
            $object['product:price:amount']   = $model->amount;
            $object['product:price:currency'] = 'USD';
        }
        if ($model->description) {
            $object['og:description'] = $model->description;
        }

        if ($model->category) {
            $object['product:category'] = $model->category->title;
        }

        if ($model->image) {
            $data               = CJSON::decode($model->image->data);
            $object['og:image'] = 'https://' . $_SERVER['HTTP_HOST'] . $data['xl'];
        }

        $object['og:url'] = 'http://www.facebook.com/' . $model->shop->fb_id . '?' . http_build_query(
            array(
                'sk'       => 'app_' . Yii::app()->facebook->sdk->getAppId(),
                'app_data' => CJSON::encode(
                    array(
                        'product_id' => $model->id
                    )
                )
            )
        );

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

        if (!$model->fb_id) {
            $opts[CURLOPT_URL] = 'https://graph.facebook.com/app/objects/product';
            curl_setopt_array($ch, $opts);
            $result       = CJSON::decode(curl_exec($ch));
            $model->fb_id = $result['id'];
            return true;
        } else {
            $opts[CURLOPT_URL] = 'https://graph.facebook.com/' . $model->fb_id;
            curl_setopt_array($ch, $opts);
            curl_exec($ch);
            return true;
        }
    }
}