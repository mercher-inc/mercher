<?php
/**
 * @var $this ProductsController
 * @var $model Product
 */

Yii::app()->controller->headerTitle = Yii::t('label', 'products');

array_push(
    Yii::app()->controller->headerButtons,
    [
        'title' => Yii::t('product', 'create'),
        'url'   => Yii::app()->urlManager->createUrl('products/create', array('shop_id' => $this->shop->id))
    ]
);

$this->widget(
    'application.widgets.grid.GridView',
    [
        'id'           => 'products-list',
        'dataProvider' => $model->search(),
        'columns'      => [
            [
                'type'              => 'raw',
                'value'             => '$data->image_id?CHtml::image($data->image->getSize("xs")):""',
                'headerHtmlOptions' => [
                    'style' => 'width: 80px;'
                ]
            ],
            [
                'name'               => 'title',
                'cssClassExpression' => '$data->title?"":"not_set"',
                'value'              => '$data->title?$data->title:""'
            ],
            [
                'name'               => 'category_id',
                'cssClassExpression' => '$data->category_id?"":"not_set"',
                'value'              => '$data->category_id?$data->category->title:""'
            ],
            [
                'type'               => 'raw',
                'name'               => 'amount',
                'cssClassExpression' => '$data->amount?"":"not_set"',
                'value'              => '$data->amount?("&#36;" . $data->amount):""'
            ],
            [
                'name'               => 'description',
                'cssClassExpression' => '$data->description?"":"not_set"',
                'value'              => '$data->description?$data->description:""',
                'htmlOptions'        => [
                    'style' => 'overflow: hidden; max-width: 150px; text-overflow: ellipsis;'
                ]
            ],
            [
                'name'               => 'is_active',
                'cssClassExpression' => '$data->is_active?"yes":"no"',
                'value'              => ''
            ],
            [
                'name'               => 'is_banned',
                'cssClassExpression' => '$data->is_banned?"yes":"no"',
                'value'              => ''
            ],
            [
                'type'  => 'raw',
                'value' => 'CHtml::link(
                    Yii::t("label", "edit"),
                    Yii::app()->urlManager->createUrl(
                        "products/update",
                        ["shop_id" => $data->shop_id, "product_id" => $data->id]
                    ),
                    ["class" => "btn btn-default btn-block"]
                )'
            ]
        ]
    ]
);