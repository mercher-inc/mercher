<?php

$restControllers = array(
    'shops'          => array(
        'param' => 'shop_id',
        'paths' => array(
            'api/users/<user_id:\d+>/',
            'api/',
        )
    ),
    'products'          => array(
        'param' => 'product_id',
        'paths' => array(
            'api/shops/<shop_id:\d+>/',
            'api/',
        )
    ),
);

$result = array();

foreach ($restControllers as $controller => $options) {
    if (isset($options['param'])) {
        $param = $options['param'];
    } else {
        $param = $controller . '_id';
    }

    if (!isset($options['paths'])) {
        $options['paths'] = array('api/');
    }

    foreach ($options['paths'] as $path) {
        $result[] = array(
            'api/' . $controller . '/list',
            'pattern'   => $path . $controller,
            'verb'      => 'GET',
            'urlSuffix' => false,
        );
        $result[] = array(
            'api/' . $controller . '/create',
            'pattern'   => $path . $controller,
            'verb'      => 'POST',
            'urlSuffix' => false,
        );
        $result[] = array(
            'api/' . $controller . '/read',
            'pattern'   => $path . $controller . '/<' . $param . ':\d+>',
            'verb'      => 'GET',
            'urlSuffix' => false,
        );
        $result[] = array(
            'api/' . $controller . '/update',
            'pattern'   => $path . $controller . '/<' . $param . ':\d+>',
            'verb'      => 'PUT',
            'urlSuffix' => false,
        );

        $result[] = array(
            'api/' . $controller . '/patch',
            'pattern'   => $path . $controller . '/<' . $param . ':\d+>',
            'verb'      => 'PATCH',
            'urlSuffix' => false,
        );

        $result[] = array(
            'api/' . $controller . '/delete',
            'pattern'   => $path . $controller . '/<' . $param . ':\d+>',
            'verb'      => 'DELETE',
            'urlSuffix' => false,
        );
    }

}

return $result;