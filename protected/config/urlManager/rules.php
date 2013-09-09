<?php

return array_merge(
    array(
        ''                               => 'index/index',
        'logout'                         => 'index/logout',
        'contact'                        => 'index/contact',
        'shops'                          => 'shops/index',
        'shops/<shop_id:\d+>'            => 'shops/get',
        'shops/<shop_id:\d+>/categories' => 'categories/index',
        'shops/<shop_id:\d+>/products'   => 'products/index',
        'shops/<shop_id:\d+>/orders'     => 'orders/index',
        'pages'                          => 'pages/index',
    ),
    require(dirname(__FILE__) . '/rest_rules.php'),
    require(dirname(__FILE__) . '/rpc_rules.php')
);