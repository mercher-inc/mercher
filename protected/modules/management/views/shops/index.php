<?php
/* @var $this ShopsController */
/* @var $model Shop */

$this->menu = array(
    array('label' => 'List Shop', 'url' => array('index')),
    array('label' => 'Create Shop', 'url' => array('create')),
);

$this->headerTitle = 'Manage Shops';

$this->renderPartial(
    '_search',
    array(
        'model' => $model,
    )
);

$this->widget(
    'application.widgets.grid.GridView',
    array(
        'id'           => 'shop-grid',
        'dataProvider' => $model->search(),
        'columns'      => array(
            'id',
            'created',
            'updated',
            'fb_id',
            'owner_id',
            'title',
            'description',
            'template_alias',
            'template_config',
            'is_active',
            'is_banned',
            'pp_merchant_id',
            'tax',
            array(
                'class' => 'CButtonColumn',
            ),
        ),
    )
);