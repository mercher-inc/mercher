<?php
/**
 * @var $this CategoriesController
 * @var $model Category
 */

Yii::app()->controller->headerTitle = Yii::t('label', 'categories');

if ($this->shop->categoriesCount < $this->shop->maxProductsCount) {
    array_push(
        Yii::app()->controller->headerButtons,
        [
            'title' => Yii::t(
                'category',
                'create_btn',
                [
                    '{categoriesCount}' => $this->shop->categoriesCount,
                    '{categoriesMax}'   => $this->shop->maxProductsCount
                ]
            ),
            'url'   => Yii::app()->urlManager->createUrl('categories/create', ['shop_id' => $this->shop->id])
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
                'name'               => 'title',
                'cssClassExpression' => '$data->title?"":"not_set"',
                'value'              => '$data->title?$data->title:""'
            ],
            [
                'name'               => 'is_active',
                'cssClassExpression' => '$data->is_active?"yes":"no"',
                'value'              => ''
            ],
            [
                'type'  => 'raw',
                'value' => 'CHtml::tag(
                    "div",
                    ["class"=>"btn-group btn-group-justified"],
                    CHtml::link(
                        Yii::t("label", "edit"),
                        Yii::app()->urlManager->createUrl(
                            "categories/update",
                            ["shop_id" => $data->shop_id, "category_id" => $data->id]
                        ),
                        ["class" => "btn btn-default"]
                    ) . CHtml::link(
                        Yii::t("label", "delete"),
                        Yii::app()->urlManager->createUrl(
                            "categories/delete",
                            ["shop_id" => $data->shop_id, "category_id" => $data->id]
                        ),
                        ["class" => "btn btn-default"]
                    )
                )',
                'htmlOptions'        => [
                    'style' => 'width: 200px;'
                ]
            ]
        ]
    ]
);
?>