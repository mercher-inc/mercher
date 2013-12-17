<?php
/**
 * Created by JetBrains PhpStorm.
 * Project: mercher
 * Author: dmitry
 * Date: 9/25/13
 * Time: 4:23 PM
 */

namespace templates\none;

class Template extends \CComponent
{
    protected $_form;
    protected $_widget;
    protected $_shop;
    public $config;

    public function printForm()
    {
        echo $this->widget->render('form');
    }

    public function processForm()
    {
        if (isset($_POST['templates_none_Form'])) {
            $this->form->attributes = $_POST['templates_none_Form'];
        }

        if ($this->form->validate()) {
            if ($this->buildShop()) {
                $this->shop->template_config = \CJSON::encode($this->form->attributes);
                $this->shop->save();
            }
        }
    }

    public function buildShop()
    {
        //getting paths
        $configsPath = dirname(__FILE__) . DIRECTORY_SEPARATOR . 'configs' . DIRECTORY_SEPARATOR . $this->shop->id;
        $assetsPath  = dirname(__FILE__) . DIRECTORY_SEPARATOR . 'assets' . DIRECTORY_SEPARATOR . $this->shop->id;
        $srcPath     = dirname(__FILE__) . DIRECTORY_SEPARATOR . 'src';

        $oldAssetsPath = \Yii::app()->assetManager->getPublishedPath($assetsPath);

        //creating configs dir
        if (!file_exists($configsPath) or !is_dir($configsPath)) {
            mkdir($configsPath, 0777, true);
        }

        //generating less file from config
        file_put_contents(
            $configsPath . DIRECTORY_SEPARATOR . 'config.less',
            $this->widget->render('less', null, true)
        );

        //rendering css file from less file
        exec(
            '/usr/bin/lessc -x ' . $configsPath . DIRECTORY_SEPARATOR . 'config.less',
            $outputCss,
            $errorCss
        );

        //if no errors in less file
        if (!$errorCss) {

            //creating assets dir
            if (!file_exists($assetsPath) or !is_dir($assetsPath)) {
                mkdir($assetsPath, 0777, true);
            }

            //saving generated css file
            file_put_contents($assetsPath . DIRECTORY_SEPARATOR . 'main.css', implode("\n", $outputCss));

            //generating and saving js files
            file_put_contents(
                $assetsPath . DIRECTORY_SEPARATOR . 'ga.js',
                $this->widget->render('ga', null, true)
            );
            file_put_contents(
                $assetsPath . DIRECTORY_SEPARATOR . 'fb.js',
                $this->widget->render('fb', null, true)
            );
            file_put_contents(
                $assetsPath . DIRECTORY_SEPARATOR . 'shop.js',
                $this->widget->render('shop', null, true)
            );

            //linking assets src to template src
            if (!file_exists($assetsPath . DIRECTORY_SEPARATOR . 'app')) {
                symlink($srcPath, $assetsPath . DIRECTORY_SEPARATOR . 'app');
            }

            //publishing new assets
            \Yii::app()->assetManager->publish($assetsPath, false, -1, true);
            //deleting old assets
            if (file_exists($oldAssetsPath) and is_dir($oldAssetsPath)) {
                //rmdir($oldAssetsPath);
                //var_dump($oldAssetsPath);
            }
            return true;
        }
        return false;
    }

    public function getForm()
    {
        if (!$this->_form) {
            $this->_form = \Yii::createComponent(
                array_merge_recursive(
                    $this->config,
                    array(
                        'class'    => 'templates\none\Form',
                        'template' => $this
                    )
                )
            );
        }
        return $this->_form;
    }

    public function registerScripts()
    {
        $assetsPath = dirname(__FILE__) . DIRECTORY_SEPARATOR . 'assets' . DIRECTORY_SEPARATOR . $this->shop->id;

        \Yii::app()->clientScript->registerCssFile(
            \Yii::app()->assetManager->getPublishedUrl($assetsPath) . '/main.css'
        );

        \Yii::app()->clientScript->registerScriptFile(
            '/js/require.js',
            null,
            array(
                'data-main' => \Yii::app()->assetManager->getPublishedUrl(
                    $assetsPath
                ) . '/app/main.js'
            )
        );

        $signedRequest = \Yii::app()->facebook->sdk->getSignedRequest();
        if (isset($signedRequest['app_data'])) {
            \Yii::app()->clientScript->registerScript(
                'app_data',
                'var app_data = ' . $signedRequest['app_data'] . ';',
                \CClientScript::POS_HEAD
            );
        } else {
            \Yii::app()->clientScript->registerScript(
                'app_data',
                'var app_data = {};',
                \CClientScript::POS_HEAD
            );
        }
    }

    public function getWidget()
    {
        if (!$this->_widget) {
            $this->_widget = \Yii::createComponent(
                array(
                    'class'    => 'templates\none\Widget',
                    'template' => $this
                )
            );
        }
        return $this->_widget;
    }

    public function setShop(\Shop $shop)
    {
        $this->_shop = $shop;
    }

    public function getShop()
    {
        return $this->_shop;
    }

}