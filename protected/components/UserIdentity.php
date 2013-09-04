<?php

class UserIdentity extends CBaseUserIdentity
{
    private $_user;

    public function authenticate()
    {
        $id = Yii::app()->facebook->sdk->getUser();

        if (!$id) {
            $this->errorCode = self::ERROR_UNKNOWN_IDENTITY;
            $this->errorMessage = 'You are not authorized';
            return false;
        }

        try {
            $this->_user = Yii::app()->facebook->sdk->api('/me');
        } catch (FacebookApiException $e) {
            $result = $e->getResult();
            $this->errorCode = self::ERROR_NONE;
            $this->errorMessage = 'Facebook API error: ' . $result['error']['message'];
            return false;
        }

        $user = Users::model()->findByPk($this->_user['id']);

        if ($user === null) {
            $user = new Users();
            $user->id = $this->_user['id'];
            //$user->created = date('Y-m-d H:i:s');
        }

        $user->first_name = $this->_user['first_name'];
        $user->last_name = $this->_user['last_name'];
        $user->email = $this->_user['email'];
        $user->last_login = date('Y-m-d H:i:s');

        if (!$user->save()) {
            $this->errorCode = self::ERROR_NONE;
            $this->errorMessage = 'Validation error: ' . array_shift( array_shift($user->getErrors()));
            return false;
        }

        return true;
    }

    public function getId()
    {
        return $this->_user['id'];
    }

    public function getName()
    {
        return $this->_user['name'];
    }

    public function getFirstName()
    {
        return $this->_user['first_name'];
    }

    public function getLastName()
    {
        return $this->_user['last_name'];
    }

    public function getUsername()
    {
        return $this->_user['username'];
    }

    public function getEmail()
    {
        return $this->_user['email'];
    }
}