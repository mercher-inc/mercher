<?php

Yii::$classMap['Facebook'] = Yii::getPathOfAlias('ext.facebook.src') . DIRECTORY_SEPARATOR . 'facebook.php';

class FB extends CComponent
{
    protected $_sdk;
    public $appId;
    public $secret;

    public function init()
    {
        $this->_sdk = new Facebook(array('appId' => $this->appId, 'secret' => $this->secret, 'cookie' => false));
    }

    public function getSdk()
    {
        return $this->_sdk;
    }

}