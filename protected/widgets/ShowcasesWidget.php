<?php
/**
 * Created by JetBrains PhpStorm.
 * Project: mercher
 * Author: dmitry
 * Date: 9/6/13
 * Time: 3:57 PM
 */

class ShowcasesWidget extends CWidget
{
    private static $_counter = 0;
    private $_id;
    public $showcases;

    public function init()
    {
        echo '<div id="' . $this->getId() . '">';
        $this->render('showcases_widget/list');
    }

    public function run()
    {
        echo '</div>';
    }

    public function getId()
    {
        if ($this->_id !== null) {
            return $this->_id;
        } else {
            return $this->_id = 'showcases_widget_' . self::$_counter++;
        }
    }
}