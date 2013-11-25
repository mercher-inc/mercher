<?php
/**
 * Created by JetBrains PhpStorm.
 * Project: mercher
 * Author: dmitry
 * Date: 9/25/13
 * Time: 4:33 PM
 */

namespace templates\none;


class Form extends \CFormModel
{
    protected $_template;
    public $primary_color;

    public function rules()
    {
        return array(
            array('primary_color', 'filter', 'filter' => 'strtoupper'),
            array('primary_color', 'color'),
            array('primary_color', 'safe'),
        );
    }

    public function color($attribute, $params)
    {
        if ($this->$attribute) {
            if (!preg_match('/^\#([A-F0-9]{6}|[A-F0-9]{3})$/i', $this->$attribute)) {
                $this->addError($attribute, 'Not a color');
            }
        }
    }

    public function attributeLabels()
    {
        return array(
            'primary_color' => 'Branding color',
        );
    }

    public function setTemplate(\CComponent $template)
    {
        $this->_template = $template;
    }

    public function getTemplate()
    {
        return $this->_template;
    }

    public function setTitle()
    {
    }

    public function getTitle()
    {
        return null;
    }

    public function setPer_page_count()
    {
    }

    public function getPer_page_count()
    {
        return null;
    }
}