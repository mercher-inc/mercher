<?php
/**
 * Created by JetBrains PhpStorm.
 * Project: mercher
 * Author: dmitry
 * Date: 9/23/13
 * Time: 6:58 PM
 */

class ShopActiveSyncBehavior extends CActiveRecordBehavior
{
    public function afterSave($event)
    {
        $model = $this->getOwner();

        try {
            $result = Yii::app()->facebook->sdk->api(
                '/' . $model->fb_id . '?' . http_build_query(array('fields' => 'access_token'))
            );
        } catch (Exception $e) {
            return false;
        }
        if (!$result or !isset($result['access_token'])) {
            return false;
        }

        $accessToken = $result['access_token'];

        $ch     = curl_init();
        $opts        = array(
            CURLOPT_CONNECTTIMEOUT => 10,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_TIMEOUT        => 60
        );

        if ($model->is_active) {
            $opts[CURLOPT_POSTFIELDS] = http_build_query(
                array(
                    'access_token' => $accessToken,
                    'app_id'       => Yii::app()->facebook->sdk->getAppId()
                )
            );
            $opts[CURLOPT_URL] = 'https://graph.facebook.com/' . $model->fb_id . '/tabs';
            $opts[CURLOPT_POST] = 1;
        } else {
            $opts[CURLOPT_POSTFIELDS] = http_build_query(
                array(
                    'access_token' => $accessToken
                )
            );
            $opts[CURLOPT_URL] = 'https://graph.facebook.com/' . $model->fb_id . '/tabs/app_' . Yii::app()->facebook->sdk->getAppId();
            $opts[CURLOPT_CUSTOMREQUEST] = 'DELETE';
        }

        try {
            curl_setopt_array($ch, $opts);
            CJSON::decode(curl_exec($ch));
        } catch (Exception $e) {
            return false;
        }

        return true;
    }
}