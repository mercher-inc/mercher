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
    public function afterSave(CEvent $event)
    {
        /**
         * @var $model Product
         */
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
            try {
                $result       = CJSON::decode(curl_exec($ch));
            } catch (Exception $e) {
                throw new CHttpException(500, $e->getMessage());
            }
            if (isset($result['error'])) {
                throw new CHttpException(500, $result['error']['message']);
            }
            Yii::app()->db->createCommand()->update(
                $model->tableName(),
                [
                    'fb_id' =>  $result['id']
                ],
                'id = :productId',
                [
                    'productId' => $model->id
                ]
            );
            $model->refresh();
            return true;
        } else {
            $opts[CURLOPT_URL] = 'https://graph.facebook.com/' . $model->fb_id;
            curl_setopt_array($ch, $opts);
            curl_exec($ch);
            return true;
        }
    }
}