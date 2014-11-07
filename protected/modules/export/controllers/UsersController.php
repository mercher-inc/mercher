<?php
/**
 * Created by JetBrains PhpStorm.
 * Project: mercher
 * Author: dmitry
 * Date: 9/9/13
 * Time: 4:33 PM
 */

namespace export\controllers;


class UsersController extends \Controller
{
    public $password = '4f3969cdb80a752c372e2dbcd30f163431b6f587';

    public function actionList($password)
    {
        if ($password != $this->$password) {
            throw new \CHttpException(403, 'Wrong password');
        }

        $result = array();

        $users   = \User::model()->findAll();

        if (count($users)) {
            foreach ($users as $user) {
                $model             = $user->attributes;
                $result[] = $model;
            }
        }
        echo \CJSON::encode($result);
    }
}
