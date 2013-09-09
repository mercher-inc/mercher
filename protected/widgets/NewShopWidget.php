<?php
/**
 * Created by JetBrains PhpStorm.
 * Project: mercher
 * Author: dmitry
 * Date: 9/9/13
 * Time: 10:12 AM
 */

class NewShopWidget extends CWidget
{
    private static $_counter = 0;
    private $_id;

    public function init()
    {
        echo '<div id="' . $this->getId() . '">';

        $url     = '/' . Yii::app()->request->getParam('shop_id') . '?' . http_build_query(
            array(
                'fields' => implode(',', array('id','name','description'))
            )
        );
        $cacheId = implode(
            '::',
            array(
                'fb',
                Yii::app()->user->id,
                $url
            )
        );
        $page = Yii::app()->cache->get($cacheId);
        if($page===false)
        {
            $page = Yii::app()->facebook->sdk->api($url);
            Yii::app()->cache->set($cacheId, $page, 60);
        }

        echo '<button class="btn btn-success" id="'.$this->getId().'_show_modal">Create shop for ' . $page['name'] . '</button>';

        Yii::app()->clientScript->registerPackage('mercher/views/shops/new');
        $obj = 'Mercher.' . $this->getId();
        $defaults = array('id'=>$page['id'],'title'=>$page['name']);
        if (isset($page['description'])) $defaults['description'] = $page['description'];

        Yii::app()->clientScript->registerScript(
            $this->getId(),
            "$obj = {};\n" .
                "$obj.model = new Mercher.Models.Shops();\n" .
                //"$obj.model.set('id', ".$page['id'].");\n" .
                "$obj.model.set(".CJSON::encode($defaults).");\n" .
                "$obj.view = new Mercher.Views.Shops.New({model: $obj.model});\n" .
                "$obj.view.\$el.attr(\"id\", \"{$this->getId()}_modal\");\n" .
                "$obj.view.\$el.appendTo(\"body\");\n" .
                "$(\"#{$this->getId()}_show_modal\").click(function(){ $obj.view.render(); });\n".
                "$obj.model.on(\"sync\", function(){location.reload();});"
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
            return $this->_id = 'new_shop_widget_' . self::$_counter++;
        }
    }
}