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
    public $title;
    public $primary_color;
    public $per_page_count = 9;

    public function rules()
    {
        return array(
            array('title, primary_color, per_page_count', 'safe'),
            array('per_page_count', 'in', 'range' => array('4', '9', '16')),
        );
    }

    public function attributeLabels()
    {
        return array(
            'title'          => 'Custom title',
            'primary_color'  => 'Primary color',
            'per_page_count' => 'Products on page',
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
}