<?php
/**
 * Project: mercher
 * Author: Dmitry Les
 * Date: 11/11/13
 * Time: 2:01 PM
 */

class UrlManager extends CUrlManager {

    public function createUrl($route,$params=array(),$ampersand='&')
    {
        $url = parent::createUrl($route,$params,$ampersand);
        if (Yii::app()->request->isSecureConnection) {
            $url = preg_replace('/^http:/', 'https:', $url, 1);
        }
        return $url;
    }

}