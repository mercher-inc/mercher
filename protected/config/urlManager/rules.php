<?php

return array_merge(
    array(
        ''                                                          => 'index/index',
        'logout'                                                    => 'index/logout',
        'contact'                                                   => 'index/contact',
        //==Shops==
        'shops'                                                     => 'shops/index',
        'shops/new'                                                 => 'shops/create',
        'shops/<shop_id:\d+>'                                       => 'shops/read',
        'shops/<shop_id:\d+>/settings'                              => 'shops/update',
        'shops/<shop_id:\d+>/delete'                                => 'shops/delete',
        //==Categories==
        'shops/<shop_id:\d+>/categories'                            => 'categories/index',
        'shops/<shop_id:\d+>/categories/new'                        => 'categories/create',
        'shops/<shop_id:\d+>/categories/<category_id:\d+>'          => 'categories/read',
        'shops/<shop_id:\d+>/categories/<category_id:\d+>/settings' => 'categories/update',
        'shops/<shop_id:\d+>/categories/<category_id:\d+>/delete'   => 'categories/delete',
        //==Products==
        'shops/<shop_id:\d+>/products'                              => 'products/index',
        'shops/<shop_id:\d+>/products/new'                          => 'products/create',
        'shops/<shop_id:\d+>/products/<product_id:\d+>'             => 'products/read',
        'shops/<shop_id:\d+>/products/<product_id:\d+>/settings'    => 'products/update',
        'shops/<shop_id:\d+>/products/<product_id:\d+>/delete'      => 'products/delete',
        //==Orders==
        'shops/<shop_id:\d+>/orders'                                => 'orders/index',
        'shops/<shop_id:\d+>/orders/<order_id:\d+>'                 => 'orders/read',
        //==Design==
        'shops/<shop_id:\d+>/design'                                => 'design/index',
    ),
    require(dirname(__FILE__) . '/rest_rules.php'),
    require(dirname(__FILE__) . '/rpc_rules.php')
);