<?php
/* @var $this ProductsController */
/* @var $model Product */

$this->menu = array(
    array('label' => 'List Product', 'url' => array('index')),
    array('label' => 'Create Product', 'url' => array('create')),
);

$this->headerTitle = 'Manage Products';

$this->renderPartial(
    '_search',
    array(
        'model' => $model,
    )
);

$this->widget(
    'application.widgets.grid.GridView',
    array(
        'id'           => 'product-grid',
        'dataProvider' => $model->search(),
        'columns'      => array(
            'id',
            'created',
            'updated',
            'fb_id',
            'shop_id',
            'category_id',
            'title',
            'description',
            'image_id',
            'amount',
            'is_active',
            'is_banned',
            'quantity_in_stock',
            array(
                'class' => 'CButtonColumn',
            ),
        ),
    )
);
