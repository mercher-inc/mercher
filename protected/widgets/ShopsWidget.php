<?php
/**
 * Created by JetBrains PhpStorm.
 * Project: mercher
 * Author: dmitry
 * Date: 9/5/13
 * Time: 3:11 PM
 */

class ShopsWidget extends CWidget
{
    private static $_counter = 0;
    private $_id;
    public $shops;

    public function init()
    {
        echo '<div id="' . $this->getId() . '">';
        $this->render('shops_widget/list');
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
            return $this->_id = 'shops_widget_' . self::$_counter++;
        }
    }
}