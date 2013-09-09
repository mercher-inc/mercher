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
    public $shop_id;

    public function init()
    {
        echo '<div id="' . $this->getId() . '">';

        $params = array(
            'page'  => 1,
            'limit' => 10
        );

        $context = array(
            'shop_id' => $this->shop_id
        );

        $query = array_replace_recursive(
            $params,
            $context
        );

        try {
            $collection = Products::model()->readRestCollection($query);
        } catch (CHttpException $e) {
            var_dump($e);
            echo '<div class="alert alert-error">' . $e->getMessage() . '</div>';
            return;
        }

        echo '<h1>' . Yii::t('label', 'products') . '</h1>';

        Yii::app()->clientScript->registerPackage('mercher/views/shops/list');
        $obj = 'Mercher.' . $this->getId();
        Yii::app()->clientScript->registerScript(
            $this->getId(),
            "$obj = {};\n" .
                "$obj.collection = new Mercher.Collections.Shops();\n" .
                "$obj.view = new Mercher.Views.Shops.List({collection: $obj.collection});\n" .
                "$obj.view.\$el.appendTo(\"#" . $this->getId() . "\");\n" .
                "$obj.collection.reset($obj.collection.parse(" . CJSON::encode($collection) . "));\n"
        );
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