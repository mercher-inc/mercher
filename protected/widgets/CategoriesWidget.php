<?php
/**
 * Created by JetBrains PhpStorm.
 * Project: mercher
 * Author: dmitry
 * Date: 9/9/13
 * Time: 1:33 PM
 */

class CategoriesWidget extends CWidget
{
    private static $_counter = 0;
    private $_id;
    public $shop;
    public $categories;

    public function init()
    {
        echo '<div id="' . $this->getId() . '">';
        $this->render('categories_widget/list');
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
            return $this->_id = 'categories_widget_' . self::$_counter++;
        }
    }
}