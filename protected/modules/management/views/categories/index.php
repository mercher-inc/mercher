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
            'title',
            [
                'name' => 'description',
                'htmlOptions' => [
                    'style'=>'overflow: hidden; max-width: 150px; text-overflow: ellipsis;'
                ]
            ],
            [
                'name' => 'shop_id',
                'value'=> 'CHtml::link($data->shop->title, Yii::app()->urlManager->createUrl("management/shops/view", ["id"=>$data->shop_id]))',
                'type' => 'raw'
            ],
            [
                'name' => 'is_active',
                'type' => 'boolean'
            ],
            [
                'name' => 'is_banned',
                'type' => 'boolean'
            ],
            [
                'name' => 'created',
                'type' => 'datetime'
            ],
            [
                'name' => 'updated',
                'type' => 'datetime'
            ],
            array(
                'class' => 'CButtonColumn',
            ),
        ),
    )
);