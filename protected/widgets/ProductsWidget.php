<?php
/**
 * Created by JetBrains PhpStorm.
 * Project: mercher
 * Author: dmitry
 * Date: 9/9/13
 * Time: 1:35 PM
 */

class ProductsWidget extends CWidget
{
    private static $_counter = 0;
    private $_id;
    public $shop;
    public $products;

    public function init()
    {
        echo '<div id="' . $this->getId() . '">';
        $this->render('products_widget/list');
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
            return $this->_id = 'products_widget_' . self::$_counter++;
        }
    }
}