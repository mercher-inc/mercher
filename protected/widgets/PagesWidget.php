<?php
/**
 * Created by JetBrains PhpStorm.
 * Project: mercher
 * Author: dmitry
 * Date: 9/6/13
 * Time: 3:57 PM
 */

class PagesWidget extends CWidget
{
    private static $_counter = 0;
    private $_id;

    public function init()
    {
        echo '<div id="' . $this->getId() . '">';

        $params = array(
            'offset' => 0,
            'limit'  => 10,
            'fields' => implode(
                ',',
                array(
                    'id',
                    'username',
                    'category',
                    'name',
                    'description',
                    'has_added_app',
                    'access_token'
                )
            )
        );

        echo '<h1>' . Yii::t('label', 'Pages') . '</h1>';

        Yii::app()->clientScript->registerPackage('mercher/views/pages/list');
        $obj = 'Mercher.' . $this->getId();
        Yii::app()->clientScript->registerScript(
            $this->getId(),
            "$obj = {};\n" .
                "$obj.collection = new Mercher.Facebook.Collections.Pages();\n" .
                "$obj.view = new Mercher.Views.Pages.List({collection: $obj.collection});\n" .
                "$obj.view.\$el.appendTo(\"#" . $this->getId() . "\");\n" .
                "$obj.collection.fetch(" . CJSON::encode($params) . ");\n",
            ClientScript::POS_FB
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
            return $this->_id = 'pages_widget_' . self::$_counter++;
        }
    }
}