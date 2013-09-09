<?php
/**
 * Created by JetBrains PhpStorm.
 * Project: mercher
 * Author: dmitry
 * Date: 9/5/13
 * Time: 1:40 PM
 */

class ShopsController extends Controller
{
    protected $_shop;

    public function actionIndex()
    {
        $this->render('index');
    }

    public function actionGet()
    {
        if (!$this->shop) {
            $this->render('create');
        } else {
            $this->layout = '//layouts/shop';

            $this->render(
                'get',
                array(
                    'shop' => $this->shop
                )
            );
        }
        /*
        $product = new Products();
        $product->title = 'New product';
        $product->price = '100';
        $product->description = 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent egestas magna vel sapien semper molestie. Ut et nisi nec urna pulvinar pulvinar ac ac purus. Ut sed pulvinar nisi, et placerat nisi. Sed est quam, dignissim nec aliquam eget, accumsan quis dui. Donec id ornare sem. Ut adipiscing, turpis et vestibulum luctus, elit arcu aliquet purus, quis placerat mi diam nec nisi. Sed faucibus tempus dolor, ut porttitor justo. Aenean lacus nisl, lacinia sit amet lorem eget, commodo interdum sem. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos.';
        $product->shop_id = 1;

        if (!$product->save()) {
            var_dump($product->getErrors());
        }
        var_dump($product);
        */


    }

    public function getShop() {
        if ($this->_shop === null) {
            $this->_shop = Shops::model()->findByPk(Yii::app()->request->getParam('shop_id'));
        }
        return $this->_shop;
    }
}