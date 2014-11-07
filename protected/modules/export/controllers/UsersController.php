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
    public function actionList()
    {
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
