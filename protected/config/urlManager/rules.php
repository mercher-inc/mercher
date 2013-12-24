<?php

return array_merge(
    array(
        'http://tab.<hostname:(mercher.dev|mercher.net)>/'                                              => 'tab/index/index',
        'https://tab.<hostname:(mercher.dev|mercher.net)>/'                                             => 'tab/index/index',
        'management'                                                                                    => 'management/index/index',
        'management/<_a:(login|logout)>'                                                                => 'management/index/<_a>',
        'management/<_c:(users|shops|products|categories|subscriptions)>/<id:\d+>/<_a:(update|delete)>' => 'management/<_c>/<_a>',
        'management/<_c:(users|shops|products|categories|subscriptions)>/<id:\d+>'                      => 'management/<_c>/view',
        'management/<_c:(users|shops|products|categories|subscriptions)>/<_a:(create|admin)'            => 'management/<_c>/<_a>',
        'management/<_c:(users|shops|products|categories|subscriptions)>'                               => 'management/<_c>/index',
        ''                                                                                              => 'index/index',
        'logout'                                                                                        => 'index/logout',
        'contact'                                                                                       => 'index/contact',
        //==Shops==
        'shops'                                                                                         => 'shops/index',
        'shops/new'                                                                                     => 'shops/create',
        'shops/<shop_id:\d+>'                                                                           => 'shops/read',
        'shops/<shop_id:\d+>/settings'                                                                  => 'shops/update',
        'shops/<shop_id:\d+>/delete'                                                                    => 'shops/delete',
        //==Managers==
        'shops/<shop_id:\d+>/managers'                                                                  => 'managers/index',
        'shops/<shop_id:\d+>/managers/add'                                                              => 'managers/create',
        'shops/<shop_id:\d+>/managers/<user_id:\d+>'                                                    => 'managers/read',
        'shops/<shop_id:\d+>/managers/<user_id:\d+>/settings'                                           => 'managers/update',
        'shops/<shop_id:\d+>/managers/<user_id:\d+>/delete'                                             => 'managers/delete',
        //==Categories==
        'shops/<shop_id:\d+>/categories'                                                                => 'categories/index',
        'shops/<shop_id:\d+>/categories/new'                                                            => 'categories/create',
        'shops/<shop_id:\d+>/categories/<category_id:\d+>'                                              => 'categories/read',
        'shops/<shop_id:\d+>/categories/<category_id:\d+>/settings'                                     => 'categories/update',
        'shops/<shop_id:\d+>/categories/<category_id:\d+>/delete'                                       => 'categories/delete',
        //==Products==
        'shops/<shop_id:\d+>/products'                                                                  => 'products/index',
        'shops/<shop_id:\d+>/products/new'                                                              => 'products/create',
        'shops/<shop_id:\d+>/products/<product_id:\d+>'                                                 => 'products/read',
        'shops/<shop_id:\d+>/products/<product_id:\d+>/settings'                                        => 'products/update',
        'shops/<shop_id:\d+>/products/<product_id:\d+>/delete'                                          => 'products/delete',
        //==Orders==
        'shops/<shop_id:\d+>/orders'                                                                    => 'orders/index',
        'shops/<shop_id:\d+>/orders/<order_id:\d+>'                                                     => 'orders/read',
        //==Design==
        'shops/<shop_id:\d+>/design'                                                                    => 'design/index',
        'wizard/create_shop'                                                                            => 'wizard/step1',
        'wizard/create_category'                                                                        => 'wizard/step2',
        'wizard/create_product'                                                                         => 'wizard/step3',
        //==Static pages==
        'policy'                                                                                        => [
            'index/page',
            'defaultParams' => [
                'view' => 'policy'
            ]
        ],
        'terms'                                                                                         => [
            'index/page',
            'defaultParams' => [
                'view' => 'terms'
            ]
        ],
        //==OpenGraph==
        'og/subscription/<subscription_id:\d+>'                                                         => 'og/subscription',
        'og/products/<product_id:\d+>'                                                                  => 'og/products'
    ),
    require(dirname(__FILE__) . '/rest_rules.php'),
    require(dirname(__FILE__) . '/rpc_rules.php')
);