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

        $accessToken = Yii::app()->facebook->sdk->getAppId() . '|' . Yii::app()->facebook->sdk->getAppSecret();
        $opts        = array(
            CURLOPT_CONNECTTIMEOUT => 10,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_TIMEOUT        => 60,
            CURLOPT_POSTFIELDS     => http_build_query(
                array(
                    'access_token' => $accessToken,
                    'object'       => CJSON::encode($model->ogParams)
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