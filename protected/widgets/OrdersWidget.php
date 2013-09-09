<?php
/**
 * Created by JetBrains PhpStorm.
 * Project: mercher
 * Author: dmitry
 * Date: 9/9/13
 * Time: 1:35 PM
 */

class OrdersWidget extends CWidget
{
    private static $_counter = 0;
    private $_id;

    public function init()
    {
        echo '<div id="' . $this->getId() . '">';

        $params = array(
            'page'  => 1,
            'limit' => 10
        );

        $context = array(
            'user_id' => Yii::app()->user->id
        );

        $query = array_replace_recursive(
            $params,
            $context,
            array( //'company_id' => (int)Yii::app()->request->getParam('company_id')
            )
        );

        try {
            $collection = Shops::model()->readRestCollection($query);
        } catch (CHttpException $e) {
            var_dump($e);
            echo '<div class="alert alert-error">' . $e->getMessage() . '</div>';
            return;
        }

        echo '<h1>' . Yii::t('label', 'shops') . '</h1>';

        if (!$collection['count']) {
            echo '<div class="alert alert-info">' . Yii::t('error', 'shops_not_found') . '</div>';
            return;
        }

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
            return $this->_id = 'orders_widget_' . self::$_counter++;
        }
    }
}