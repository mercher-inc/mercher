<?php

class IndexController extends Controller
{
	public function actionIndex()
	{
		$this->render('index');
	}

    /**
     * Displays the login page
     */
    public function actionLogin()
    {
        $model=Yii::createComponent('management.models.LoginForm');

        // collect user input data
        if(isset($_POST['LoginForm']))
        {
            $model->attributes=$_POST['LoginForm'];
            // validate user input and redirect to the previous page if valid
            if($model->validate() && $model->login())
                $this->redirect(array('index'));
        }
        // display the login form
        $this->render('login',array('model'=>$model));
    }

    /**
     * Logs out the current user and redirect to homepage.
     */
    public function actionLogout()
    {
        Yii::app()->user->logout(false);
        $this->redirect(array('index'));
    }
}