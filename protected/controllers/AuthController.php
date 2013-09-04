<?php
/**
 * Created by JetBrains PhpStorm.
 * Project: mercher
 * Author: dmitry
 * Date: 9/4/13
 * Time: 5:43 PM
 */

class AuthController extends Controller
{
    /**
     * Displays the login page
     */
    public function actionLogin()
    {
        if (Yii::app()->request->getParam('code')) {
            $identity = new UserIdentity();
            if ($identity->authenticate()) {
                Yii::app()->user->login($identity, 3600 * 24 * 7);
                $this->redirect(Yii::app()->user->returnUrl);
            } else {
                echo $identity->errorMessage;
                //$this->redirect(Yii::app()->homeUrl);
            }
        } elseif (!Yii::app()->user->isGuest) {
            $this->redirect(Yii::app()->homeUrl);
        }
        $this->render('login');
    }

    /**
     * Logs out the current user and redirect to homepage.
     */
    public function actionLogout()
    {
        Yii::app()->user->logout();
        $this->redirect(Yii::app()->homeUrl);
    }
}