<?php

return array_merge(
    array(
        ''                                 => 'index/index',
        'logout'                           => 'index/logout',
        'contact'                          => 'index/contact',
        //==Shops==
        'shops'                            => 'shops/index',
        'shops/<shop_id:\d+>'              => 'shops/get',
        'shops/<shop_id:\d+>/edit'         => 'shops/edit',
        'shops/<shop_id:\d+>/delete'       => 'shops/delete',
        //==Showcases==
        'showcases'                        => 'showcases/index',
        'showcases/<showcase_id:\d+>'      => 'showcases/get',
        'showcases/<showcase_id:\d+>/edit' => 'showcases/edit',
        'showcases/add/<page_id:\d+>'      => 'showcases/add',
        //==Categories==
        'shops/<shop_id:\d+>/categories'   => 'categories/index',
        'categories/<category_id:\d+>'     => 'categories/get',
        //==Products==
        'shops/<shop_id:\d+>/products'     => 'products/index',
        'products/<product_id:\d+>'        => 'products/get',
        //==Orders==
        'shops/<shop_id:\d+>/orders'       => 'orders/index',
        'orders/<order_id:\d+>'            => 'orders/get',
    ),
    require(dirname(__FILE__) . '/rest_rules.php'),
    require(dirname(__FILE__) . '/rpc_rules.php')
);