<?php

return array(
    array(
        'api/categories/list',
        'pattern'   => 'api/shops/<shop_id:\d+>/categories',
        'verb'      => 'GET',
        'urlSuffix' => false,
    ),
    array(
        'api/categories/read',
        'pattern'   => 'api/shops/<shop_id:\d+>/categories/<category_id:\d+>',
        'verb'      => 'GET',
        'urlSuffix' => false,
    ),
    array(
        'api/products/list',
        'pattern'   => 'api/shops/<shop_id:\d+>/products',
        'verb'      => 'GET',
        'urlSuffix' => false,
    ),
    array(
        'api/products/read',
        'pattern'   => 'api/shops/<shop_id:\d+>/products/<product_id:\d+>',
        'verb'      => 'GET',
        'urlSuffix' => false,
    ),
    array(
        'api/images/upload',
        'pattern'   => 'api/shops/<shop_id:\d+>/images',
        'verb'      => 'POST',
        'urlSuffix' => false,
    ),
);