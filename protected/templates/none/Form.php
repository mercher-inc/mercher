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
    public $bg_color;

    public function rules()
    {
        return array(
            array('title, bg_color', 'safe'),
        );
    }

    public function attributeLabels()
    {
        return array(
            'title'    => 'Custom title',
            'bg_color' => 'Background color',
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