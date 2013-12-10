<?php
/**
 * Created by JetBrains PhpStorm.
 * Project: mercher
 * Author: dmitry
 * Date: 9/23/13
 * Time: 6:58 PM

 */

/**
 * Class ShopActiveSyncBehavior
 * @property $pageAccessToken
 * @property $isTabExists
 */
class ShopActiveSyncBehavior extends CActiveRecordBehavior
{
    protected $_pageAccessToken;
    protected $_isTabExists;

    public function afterSave($event)
    {
        if ($this->getOwner()->is_active) {
            if (!$this->isTabExists) {
                $this->createTab();
                $this->getIsTabExists(true);
            }
            $this->updateTab();
        } else {
            $this->deleteTab();
        }

        return true;
    }

    protected function getPageAccessToken()
    {
        if ($this->_pageAccessToken === null) {
            try {
                $result = Yii::app()->facebook->sdk->api(
                    '/' . $this->getOwner()->fb_id . '?' . http_build_query(array('fields' => 'access_token'))
                );
            } catch (Exception $e) {
                return false;
            }
            if (!$result or !isset($result['access_token'])) {
                return false;
            }
            $this->_pageAccessToken = $result['access_token'];
        }
        return $this->_pageAccessToken;
    }

    protected function getIsTabExists($reset = false)
    {
        if ($this->_isTabExists === null or $reset) {
            $ch                = curl_init();
            $opts              = array(
                CURLOPT_CONNECTTIMEOUT => 10,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_TIMEOUT        => 60
            );
            $opts[CURLOPT_URL] = 'https://graph.facebook.com/'
                . $this->getOwner()->fb_id
                . '/tabs/app_'
                . Yii::app()->facebook->sdk->getAppId()
                . '?'
                . http_build_query(
                    [
                        'access_token' => $this->pageAccessToken
                    ]
                );
            try {
                curl_setopt_array($ch, $opts);
                $result = CJSON::decode(curl_exec($ch));
            } catch (Exception $e) {
                return null;
            }
            if (!isset($result['data'])) {
                return null;
            }
            if (!count($result['data'])) {
                $this->_isTabExists = false;
            } else {
                $this->_isTabExists = true;
            }
        }
        return $this->_isTabExists;
    }

    protected function createTab()
    {
        if (!$this->isTabExists) {
            $ch                       = curl_init();
            $opts                     = array(
                CURLOPT_CONNECTTIMEOUT => 10,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_TIMEOUT        => 60
            );
            $opts[CURLOPT_POSTFIELDS] = http_build_query(
                array(
                    'access_token' => $this->pageAccessToken,
                    'app_id'       => Yii::app()->facebook->sdk->getAppId()
                )
            );
            $opts[CURLOPT_URL]        = 'https://graph.facebook.com/' . $this->getOwner()->fb_id . '/tabs';
            $opts[CURLOPT_POST]       = 1;

            try {
                curl_setopt_array($ch, $opts);
                return CJSON::decode(curl_exec($ch));
            } catch (Exception $e) {
                return false;
            }
        }
        return false;
    }

    protected function updateTab()
    {
        if ($this->isTabExists) {
            $ch                       = curl_init();
            $opts                     = array(
                CURLOPT_CONNECTTIMEOUT => 10,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_TIMEOUT        => 60
            );
            $obj = [
                'access_token'                  => $this->pageAccessToken,
                'custom_name'                   => $this->getOwner()->title,
                'position'                      => '2',
                'is_non_connection_landing_tab' => true,
            ];
            if ($this->getOwner()->image_id) {
                $obj['custom_image_url'] = 'https://' . $_SERVER['HTTP_HOST'] . $this->getOwner()->image->getSize('sh');
            }
            $opts[CURLOPT_POSTFIELDS] = http_build_query($obj);
            $opts[CURLOPT_URL]        = 'https://graph.facebook.com/'
                . $this->getOwner()->fb_id
                . '/tabs/app_'
                . Yii::app()->facebook->sdk->getAppId();
            $opts[CURLOPT_POST]       = 1;

            try {
                curl_setopt_array($ch, $opts);
                return CJSON::decode(curl_exec($ch));
            } catch (Exception $e) {
                return false;
            }

        }
        return false;
    }

    protected function deleteTab()
    {
        if ($this->isTabExists) {
            $ch                          = curl_init();
            $opts                        = array(
                CURLOPT_CONNECTTIMEOUT => 10,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_TIMEOUT        => 60
            );
            $opts[CURLOPT_POSTFIELDS]    = http_build_query(
                array(
                    'access_token' => $this->pageAccessToken
                )
            );
            $opts[CURLOPT_URL]           = 'https://graph.facebook.com/'
                . $this->getOwner()->fb_id
                . '/tabs/app_'
                . Yii::app()->facebook->sdk->getAppId();
            $opts[CURLOPT_CUSTOMREQUEST] = 'DELETE';

            try {
                curl_setopt_array($ch, $opts);
                return CJSON::decode(curl_exec($ch));
            } catch (Exception $e) {
                return false;
            }
        }
        return false;
    }


}