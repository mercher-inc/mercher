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
            'title',
            [
                'name'        => 'description',
                'htmlOptions' => [
                    'style' => 'overflow: hidden; max-width: 150px; text-overflow: ellipsis;'
                ]
            ],
            [
                'name'  => 'fb_id',
                'value' => 'CHtml::link($data->fb_id, "https://www.facebook.com/".$data->fb_id, ["target"=>"_blank"])',
                'type'  => 'raw'
            ],
            [
                'name'  => 'shop_id',
                'value' => 'CHtml::link($data->shop->title, Yii::app()->urlManager->createUrl("management/shops/view", ["id"=>$data->shop_id]))',
                'type'  => 'raw'
            ],
            [
                'name'  => 'category_id',
                'value' => '$data->category_id?CHtml::link($data->category->title, Yii::app()->urlManager->createUrl("management/categories/view", ["id"=>$data->category_id])):""',
                'type'  => 'raw'
            ],
            [
                'value' => '$data->image_id?$data->image->getSize("xs"):""',
                'type'  => 'image'
            ],
            'price',
            'quantity_in_stock',
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
