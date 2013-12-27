<?php
/**
 * @var $this ProductsController
 * @var $model Product
 */

Yii::app()->controller->headerTitle = Yii::t('label', 'products');

if ($this->shop->productsCount < $this->shop->maxProductsCount) {
    array_push(
        Yii::app()->controller->headerButtons,
        [
            'title' => Yii::t(
                'product',
                'create_btn',
                [
                    '{productsCount}' => $this->shop->productsCount,
                    '{productsMax}'   => $this->shop->maxProductsCount
                ]
            ),
            'url'   => Yii::app()->urlManager->createUrl('products/create', array('shop_id' => $this->shop->id)),
        ]
    );
}

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
            /*
            [
                'name'               => 'category_id',
                'cssClassExpression' => '$data->category_id?"":"not_set"',
                'value'              => '$data->category_id?$data->category->title:""'
            ],
            */
            [
                'type'               => 'raw',
                'name'               => 'amount',
                'cssClassExpression' => '$data->amount?"":"not_set"',
                'value'              => '$data->amount?("&#36;" . $data->amount):""',
                'headerHtmlOptions' => [
                    'style' => 'width: 200px;'
                ]
            ],
            [
                'name'               => 'is_active',
                'cssClassExpression' => '$data->is_active?"yes":"no"',
                'value'              => '',
                'headerHtmlOptions' => [
                    'style' => 'width: 200px;'
                ]
            ],
            [
                'type'  => 'raw',
                'value' => 'CHtml::tag(
                    "div",
                    ["class"=>"btn-group btn-group-justified"],
                    CHtml::link(
                        Yii::t("label", "edit"),
                        Yii::app()->urlManager->createUrl(
                            "products/update",
                            ["shop_id" => $data->shop_id, "product_id" => $data->id]
                        ),
                        ["class" => "btn btn-default"]
                    ) . CHtml::link(
                        Yii::t("label", "delete"),
                        Yii::app()->urlManager->createUrl(
                            "products/delete",
                            ["shop_id" => $data->shop_id, "product_id" => $data->id]
                        ),
                        ["class" => "btn btn-default"]
                    )
                )',
                'htmlOptions'        => [
                    'style' => 'width: 200px;'
                ]
            ]
            /*
            [
                'type'  => 'raw',
                'value' => 'CHtml::tag(
                        "button",
                        [
                            "type"=>"button",
                            "class" => "btn btn-default btn-block"
                        ],
                        "Like as page"
                    )',
                'htmlOptions'        => [
                    'style' => 'width: 150px;'
                ]
            ]
            */
        ]
    ]
);