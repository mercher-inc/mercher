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
        $this->form->attributes = $_POST;
        if ($this->form->validate()) {

            $configsPath = dirname(__FILE__) . DIRECTORY_SEPARATOR . 'configs' . DIRECTORY_SEPARATOR . $this->shop->id;
            $assetsPath  = dirname(__FILE__) . DIRECTORY_SEPARATOR . 'assets' . DIRECTORY_SEPARATOR . $this->shop->id;
            $srcPath     = dirname(__FILE__) . DIRECTORY_SEPARATOR . 'src';
            \Yii::app()->assetManager->publish($srcPath);

            if (!file_exists($configsPath) or !is_dir($configsPath)) {
                mkdir($configsPath, 0777, true);
            }
            file_put_contents(
                $configsPath . DIRECTORY_SEPARATOR . 'config.less',
                $this->widget->render(
                    'less',
                    array('srcPath' => \Yii::app()->assetManager->getPublishedUrl($srcPath)),
                    true
                )
            );

            exec(
                '/usr/bin/lessc --yui-compress ' . $configsPath . DIRECTORY_SEPARATOR . 'config.less',
                $outputCss,
                $errorCss
            );

            if (!$errorCss) {
                if (!file_exists($assetsPath) or !is_dir($assetsPath)) {
                    mkdir($assetsPath, 0777, true);
                }
                file_put_contents($assetsPath . DIRECTORY_SEPARATOR . 'main.css', implode("\n", $outputCss));
                file_put_contents(
                    $assetsPath . DIRECTORY_SEPARATOR . 'main.js',
                    $this->widget->render(
                        'js',
                        array('srcPath' => \Yii::app()->assetManager->getPublishedUrl($srcPath)),
                        true
                    )
                );
                \Yii::app()->assetManager->publish($assetsPath, false, -1, true);
            }

            \Yii::app()->user->setFlash(
                'success',
                'Template config saved. <a href="//www.facebook.com/' .
                    $this->shop->fb_id .
                    '?sk=app_' .
                    \Yii::app()->facebook->sdk->getAppId() .
                    '" class="alert-link" target="_blank">View result</a>'
            );
            $this->shop->template_config = \CJSON::encode($this->form->attributes);
            $this->shop->save();
        }
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
        $srcPath    = dirname(__FILE__) . DIRECTORY_SEPARATOR . 'src';

        \Yii::app()->assetManager->publish($assetsPath);

        \Yii::app()->clientScript->registerCssFile(
            \Yii::app()->assetManager->getPublishedUrl($assetsPath) . DIRECTORY_SEPARATOR . 'main.css'
        );

        \Yii::app()->clientScript->registerScriptFile(
            \Yii::app()->assetManager->getPublishedUrl($assetsPath) . DIRECTORY_SEPARATOR . 'main.js'
        );

        \Yii::app()->clientScript->registerScriptFile(
            '/js/require.js',
            null,
            array(
                'data-main' => \Yii::app()->assetManager->getPublishedUrl($srcPath) . DIRECTORY_SEPARATOR . 'main.js'
            )
        );
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