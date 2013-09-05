<?php

return array(
    'jquery'                             => array(
        'baseUrl' => '/',
        'js'      => array(
            'js/jquery.js'
        )
    ),
    'underscore'                         => array(
        'baseUrl' => '/',
        'js'      => array(
            'js/underscore.js'
        )
    ),
    'backbone'                           => array(
        'baseUrl' => '/',
        'js'      => array(
            'js/backbone.js'
        ),
        'depends' => array(
            'jquery',
            'underscore'
        ),
    ),
    'mercher'                            => array(
        'baseUrl' => '/',
        'js'      => array(
            'js/mercher.js'
        ),
        'depends' => array(
            'backbone'
        ),
    ),
    'mercher/models'                     => array(
        'baseUrl' => '/',
        'js'      => array(
            'js/mercher/models.js'
        ),
        'depends' => array(
            'mercher',
            'backbone'
        ),
    ),
    'mercher/collections'                => array(
        'baseUrl' => '/',
        'js'      => array(
            'js/mercher/collections.js'
        ),
        'depends' => array(
            'mercher',
            'backbone',
            'mercher/models'
        ),
    ),
    'mercher/views'                      => array(
        'baseUrl' => '/',
        'js'      => array(
            'js/mercher/views.js'
        ),
        'depends' => array(
            'mercher',
            'backbone'
        ),
    ),
    'mercher/templates'                  => array(
        'baseUrl' => '/',
        'js'      => array(
            'js/mercher/templates.js'
        ),
        'depends' => array(
            'mercher',
            'underscore'
        ),
    ),
    'mercher/models/shops'               => array(
        'baseUrl' => '/',
        'js'      => array(
            'js/mercher/models/shops.js'
        ),
        'depends' => array(
            'mercher/models'
        ),
    ),
    'mercher/collections/shops'          => array(
        'baseUrl' => '/',
        'js'      => array(
            'js/mercher/collections/shops.js'
        ),
        'depends' => array(
            'mercher/collections',
            'mercher/models/shops'
        ),
    ),
    'mercher/views/shops'                => array(
        'baseUrl' => '/',
        'js'      => array(
            'js/mercher/views/shops.js'
        ),
        'depends' => array(
            'mercher/views'
        ),
    ),
    'mercher/views/shops/list'           => array(
        'baseUrl' => '/',
        'js'      => array(
            'js/mercher/views/shops/list.js'
        ),
        'depends' => array(
            'mercher/views/shops',
            'mercher/collections/shops',
            'mercher/templates/shops/list',
            'mercher/views/shops/item'
        ),
    ),
    'mercher/views/shops/item'           => array(
        'baseUrl' => '/',
        'js'      => array(
            'js/mercher/views/shops/item.js'
        ),
        'depends' => array(
            'mercher/views/shops',
            'mercher/models/shops',
            'mercher/templates/shops/item',
        ),
    ),
    'mercher/templates/shops'            => array(
        'baseUrl' => '/',
        'js'      => array(
            'js/mercher/templates/shops.js'
        ),
        'depends' => array(
            'mercher/templates'
        ),
    ),
    'mercher/templates/shops/list'       => array(
        'baseUrl' => '/',
        'js'      => array(
            'js/mercher/templates/shops/list.js'
        ),
        'depends' => array(
            'mercher/templates/shops'
        ),
    ),
    'mercher/templates/shops/item'       => array(
        'baseUrl' => '/',
        'js'      => array(
            'js/mercher/templates/shops/item.js'
        ),
        'depends' => array(
            'mercher/templates/shops'
        ),
    ),
    'mercher/facebook'                   => array(
        'baseUrl' => '/',
        'js'      => array(
            'js/mercher/facebook.js'
        ),
        'depends' => array(
            'mercher'
        ),
    ),
    'mercher/facebook/models'            => array(
        'baseUrl' => '/',
        'js'      => array(
            'js/mercher/facebook/models.js'
        ),
        'depends' => array(
            'mercher/facebook',
            'backbone'
        ),
    ),
    'mercher/facebook/collections'       => array(
        'baseUrl' => '/',
        'js'      => array(
            'js/mercher/facebook/collections.js'
        ),
        'depends' => array(
            'mercher/facebook',
            'backbone',
            'mercher/facebook/models'
        ),
    ),
    'mercher/facebook/models/pages'      => array(
        'baseUrl' => '/',
        'js'      => array(
            'js/mercher/facebook/models/pages.js'
        ),
        'depends' => array(
            'mercher/facebook/models'
        ),
    ),
    'mercher/facebook/collections/pages' => array(
        'baseUrl' => '/',
        'js'      => array(
            'js/mercher/facebook/collections/pages.js'
        ),
        'depends' => array(
            'mercher/facebook/collections',
            'mercher/facebook/models/pages'
        ),
    ),
);