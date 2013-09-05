<?php

Yii::$classMap['Facebook'] = Yii::getPathOfAlias('ext.facebook.src') . DIRECTORY_SEPARATOR . 'facebook.php';

class FB extends CComponent
{
    protected $_sdk;
    protected $_scope;
    public $appId;
    public $secret;
    public $namespace;


    public function init()
    {
        $this->_sdk = new Facebook(array(
            'appId'      => $this->appId,
            'secret'     => $this->secret,
            'fileUpload' => false
        ));
    }

    public function setScope($scope)
    {
        if (is_array($scope)) {
            $this->_scope = implode(',', $scope);
        } else {
            $this->_scope = (string)$scope;
        }
    }

    public function getScope()
    {
        return $this->_scope;
    }

    public function getSdk()
    {
        return $this->_sdk;
    }

    public function getLoginUrl()
    {
        return $this->sdk->getLoginUrl(
            array(
                'scope'        => $this->scope,
                'redirect_uri' => Yii::app()->createUrl('auth/login')
                //'redirect_uri' => $this->appUrl
            )
        );
    }

    public function getAppUrl()
    {
        return 'http://apps.facebook.com/' . $this->namespace . '/';
    }

}