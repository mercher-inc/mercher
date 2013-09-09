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
    'bootstrap'                           => array(
        'baseUrl' => '/',
        'js'      => array(
            'bootstrap/js/modal.js',
            'bootstrap/js/button.js',
        ),
        'depends' => array(
            'jquery'
        ),
    ),
    'mercher'                            => array(
        'baseUrl' => '/',
        'js'      => array(
            'js/mercher.js'
        ),
        'depends' => array(
            'backbone',
            'bootstrap'
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
    'mercher/views/dlg'                => array(
        'baseUrl' => '/',
        'js'      => array(
            'js/mercher/views/dlg.js'
        ),
        'depends' => array(
            'mercher/views'
        ),
    ),
    'mercher/views/dlg/new'           => array(
        'baseUrl' => '/',
        'js'      => array(
            'js/mercher/views/dlg/new.js'
        ),
        'depends' => array(
            'mercher/views/dlg'
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
    'mercher/views/shops/new'           => array(
        'baseUrl' => '/',
        'js'      => array(
            'js/mercher/views/shops/new.js'
        ),
        'depends' => array(
            'mercher/views/shops',
            'mercher/views/dlg/new',
            'mercher/models/shops',
            'mercher/templates/shops/new',
        ),
    ),
    'mercher/views/pages'                => array(
        'baseUrl' => '/',
        'js'      => array(
            'js/mercher/views/pages.js'
        ),
        'depends' => array(
            'mercher/views'
        ),
    ),
    'mercher/views/pages/list'           => array(
        'baseUrl' => '/',
        'js'      => array(
            'js/mercher/views/pages/list.js'
        ),
        'depends' => array(
            'mercher/views/pages',
            'mercher/facebook/collections/pages',
            'mercher/templates/pages/list',
            'mercher/views/pages/item'
        ),
    ),
    'mercher/views/pages/item'           => array(
        'baseUrl' => '/',
        'js'      => array(
            'js/mercher/views/pages/item.js'
        ),
        'depends' => array(
            'mercher/views/pages',
            'mercher/facebook/models/pages',
            'mercher/templates/pages/item',
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
    'mercher/templates/shops/new'       => array(
        'baseUrl' => '/',
        'js'      => array(
            'js/mercher/templates/shops/new.js'
        ),
        'depends' => array(
            'mercher/templates/shops'
        ),
    ),
    'mercher/templates/pages'            => array(
        'baseUrl' => '/',
        'js'      => array(
            'js/mercher/templates/pages.js'
        ),
        'depends' => array(
            'mercher/templates'
        ),
    ),
    'mercher/templates/pages/list'       => array(
        'baseUrl' => '/',
        'js'      => array(
            'js/mercher/templates/pages/list.js'
        ),
        'depends' => array(
            'mercher/templates/pages'
        ),
    ),
    'mercher/templates/pages/item'       => array(
        'baseUrl' => '/',
        'js'      => array(
            'js/mercher/templates/pages/item.js'
        ),
        'depends' => array(
            'mercher/templates/pages'
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