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

            $path = dirname(__FILE__) . DIRECTORY_SEPARATOR . 'configs' . DIRECTORY_SEPARATOR . $this->shop->id;
            if (!file_exists($path) or !is_dir($path)) {
                mkdir($path, 0777, true);
            }
            file_put_contents($path . DIRECTORY_SEPARATOR . 'config.js', $this->widget->render('js', null, true));
            file_put_contents($path . DIRECTORY_SEPARATOR . 'config.less', $this->widget->render('less', null, true));

            exec('/usr/bin/lessc --yui-compress ' . $path . DIRECTORY_SEPARATOR . 'config.less', $output, $error);

            if (!$error) {
                $path = dirname(__FILE__) . DIRECTORY_SEPARATOR . 'assets' . DIRECTORY_SEPARATOR . $this->shop->id;
                if (!file_exists($path) or !is_dir($path)) {
                    mkdir($path, 0777, true);
                }
                file_put_contents($path . DIRECTORY_SEPARATOR . 'main.css', implode("\n", $output));
                file_put_contents($path . DIRECTORY_SEPARATOR . 'main.js', '');

                \Yii::app()->assetManager->publish($path, false, -1, true);
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
        \Yii::app()->assetManager->publish($assetsPath);

        \Yii::app()->clientScript->registerCssFile(
            \Yii::app()->assetManager->getPublishedUrl($assetsPath) . DIRECTORY_SEPARATOR . 'main.css'
        );
        \Yii::app()->clientScript->registerScriptFile(
            \Yii::app()->assetManager->getPublishedUrl($assetsPath) . DIRECTORY_SEPARATOR . 'main.js'
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