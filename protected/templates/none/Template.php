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