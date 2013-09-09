<?php
/**
 * Created by JetBrains PhpStorm.
 * Project: mercher
 * Author: dmitry
 * Date: 9/4/13
 * Time: 6:57 PM
 */

class PagesController extends Controller
{
    public function actionIndex()
    {
        $this->render('index');
    }
}