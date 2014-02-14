<?php

class IndexController extends CController
{
    public $layout = 'main';

    public $pageId;
    public $isAdmin;
    public $country;
    public $locale;
    public $age;
    public $data;

    protected $_shop;

    public function actionIndex()
    {
        //print_r($this->shop->attributes);

        /**
         * @var $clientScript CClientScript
         */
        $clientScript = Yii::app()->clientScript;
        $clientScript->registerCssFile(
            '/css/tab.css'
        );
        $clientScript->registerScriptFile(
            '/js/vendors/require/require-min-2.1.10.js',
            CClientScript::POS_HEAD
        );
        $clientScript->registerScriptFile(
            '/js/tab/config.js',
            CClientScript::POS_HEAD
        );
        $clientScript->registerScript(
            'collectionsPaths',
            'requirejs.config(' . CJSON::encode(
                [
                    'config' => [
                        'collections/shops'  => [
                            'url' => $this->createUrl('/api/shops/list')
                        ],
                        'collections/products'  => [
                            'url' => $this->createUrl('/api/products/list', ['shop_id' => $this->shop->id])
                        ],
                        'collections/cartItems' => [
                            'url' => $this->createUrl('/api/cart_items/list', ['shop_id' => $this->shop->id])
                        ],
                        'collections/orders'    => [
                            'url' => $this->createUrl('/api/orders/list', ['shop_id' => $this->shop->id])
                        ],
                        'models/shop'          => [
                            'urlRoot' => $this->createUrl('/api/shops/list')
                        ],
                        'models/order'          => [
                            'urlRoot' => $this->createUrl('/api/orders/list', ['shop_id' => $this->shop->id])
                        ],
                        'ga'                    => [
                            'mainTrackerId' => 'UA-23393444-14',
                            'shopTrackerId' => $this->shop->ga_id,
                        ],
                        'fb'                    => [
                            'appId'     => Yii::app()->facebook->appId,
                            'namespace' => Yii::app()->facebook->namespace,
                        ],
                        'app'                   => [
                            'data' => [
                                'shop' => $this->shop->attributes
                            ]
                        ]
                    ]
                ]
            ) . ');',
            CClientScript::POS_HEAD
        );
        $clientScript->registerScript(
            'runTabApplication',
            "window.Mercher={};require(['app'],function(tabApplication){window.Mercher.tabApp=tabApplication;});",
            CClientScript::POS_HEAD
        );

        $this->render('index');
    }

    public function actionBlank()
    {
        /**
         * @var $clientScript CClientScript
         */
        $clientScript = Yii::app()->clientScript;
        $clientScript->registerCssFile(
            '/css/tab.css'
        );
        $clientScript->registerCss(
            'transparentBody',
            'body{background: transparent;}h1{text-align:center;}'
        );
        $clientScript->registerScript(
            'closeWindow',
            'if (window.parent == window){window.close();} else if(window.parent.Mercher && window.parent.Mercher.embeddedPPFlow) {window.parent.Mercher.embeddedPPFlow.closeFlow();}',
            CClientScript::POS_HEAD
        );
        $this->render('blank');
    }

    public function getShop()
    {
        if ($this->_shop === null) {
            $signedRequest = Yii::app()->facebook->sdk->getSignedRequest();

            if (!isset($signedRequest['page']) or !isset($signedRequest['page']['id'])) {
                throw new CHttpException(403);
            }

            $this->_shop = Shop::model()->findByAttributes(
                [
                    'fb_id' => $signedRequest['page']['id']
                ]
            );

            if (!$this->_shop) {
                throw new CHttpException(404);
            }
        }

        return $this->_shop;
    }
}