<?php
/**
 * Project: mercher
 * Author: Dmitry Les
 * Date: 11/1/13
 * Time: 4:38 PM
 */

class WizardController extends Controller
{
    protected $_shop;

    public $defaultAction='step1';
    public $layout = '//layouts/wizard';

    public function filters()
    {
        return array(
            'accessControl',
        );
    }

    public function accessRules()
    {
        return array(
            array(
                'allow',
                'actions' => array(
                    'step1',
                    'step2',
                    'step3',
                    'step4'
                ),
                'users'   => array('@'),
            ),
            array(
                'deny',
                'users' => array('*'),
            ),
        );
    }

    public function actionStep1()
    {
        $this->render('step1');
    }

    public function actionStep2()
    {
        $this->render('step2');
    }

    public function actionStep3()
    {
        $this->render('step3');
    }

    public function actionStep4()
    {
        $this->render('step4');
    }
}