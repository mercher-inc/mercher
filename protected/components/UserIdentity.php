<?php

class UserIdentity extends CBaseUserIdentity
{
    private $_fbUser;
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
            $this->_fbUser = Yii::app()->facebook->sdk->api('/me');
        } catch (FacebookApiException $e) {
            $result = $e->getResult();
            $this->errorCode = self::ERROR_NONE;
            $this->errorMessage = 'Facebook API error: ' . $result['error']['message'];
            return false;
        }

        $user = User::model()->find('fb_id = :fbId', array('fbId'=>$this->_fbUser['id']));

        if ($user === null) {
            $user = new User();
            $user->fb_id = $this->_fbUser['id'];
        }

        $user->first_name = $this->_fbUser['first_name'];
        $user->last_name = $this->_fbUser['last_name'];
        $user->email = $this->_fbUser['email'];
        $user->last_login = new CDbExpression('NOW()');

        if (!$user->save()) {
            $this->errorCode = self::ERROR_NONE;
            $this->errorMessage = 'Validation error: ' . array_shift( array_shift($user->getErrors()));
            return false;
        }

        $user->refresh();

        $this->_user = $user->getAttributes();

        return true;
    }

    public function getId()
    {
        return $this->_user['id'];
    }

    public function getName()
    {
        if (!isset($this->_user['name'])) {
            $this->_user['name'] = array();
            if ($this->_user['first_name']) $this->_user['name'][] = $this->_user['first_name'];
            if ($this->_user['last_name']) $this->_user['name'][] = $this->_user['last_name'];
            if (count($this->_user['name'])) {
                $this->_user['name'] = implode(' ', $this->_user['name']);
            } else {
                $this->_user['name'] = Yii::t('label', 'anonymous');
            }
        }
        return $this->_user['name'];
    }
}