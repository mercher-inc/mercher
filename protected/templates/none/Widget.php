<?php
/**
 * Created by JetBrains PhpStorm.
 * Project: mercher
 * Author: dmitry
 * Date: 9/25/13
 * Time: 4:36 PM
 */

namespace templates\none;


class Widget extends \CWidget
{
    protected $_template;

    public function setTemplate(\CComponent $template)
    {
        $this->_template = $template;
    }

    public function getTemplate()
    {
        return $this->_template;
    }
}