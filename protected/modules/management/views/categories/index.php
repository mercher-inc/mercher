<?php
/* @var $this CategoriesController */
/* @var $model Category */

$this->menu = array(
    array('label' => 'List Category', 'url' => array('index')),
    array('label' => 'Create Category', 'url' => array('create')),
);

$this->headerTitle = 'Manage Categories';

$this->renderPartial(
    '_search',
    array(
        'model' => $model,
    )
);

$this->widget(
    'application.widgets.grid.GridView',
    array(
        'id'           => 'category-grid',
        'dataProvider' => $model->search(),
        'columns'      => array(
            'id',
            'created',
            'updated',
            'shop_id',
            'title',
            'description',
            'is_active',
            'is_banned',
            array(
                'class' => 'CButtonColumn',
            ),
        ),
    )
);