<?php
/**
 * @var $this ManagersController
 * @var $model Manager
 */

Yii::app()->controller->headerTitle = Yii::t('label', 'managers');

array_push(
    Yii::app()->controller->headerButtons,
    [
        'title' => Yii::t(
            'manager',
            'create_btn'
        ),
        'url'   => Yii::app()->urlManager->createUrl('managers/create', ['shop_id' => $this->shop->id])
    ]
);

$this->widget(
    'application.widgets.grid.GridView',
    [
        'id'           => 'managers-list',
        'dataProvider' => $model->search(),
        'columns'      => [
            [
                'type'  => 'image',
                'value' => '"https://graph.facebook.com/" . $data->user->fb_id . "/picture?type=square"',
                'headerHtmlOptions' => [
                    'style' => 'width: 80px;'
                ]
            ],
            [
                'value' => '$data->user->first_name . " " . $data->user->last_name'
            ],
            [
                'name'  => Yii::t('manager', AuthManager::ROLE_SHOP_MANAGER),
                'cssClassExpression' => 'in_array(AuthManager::ROLE_SHOP_MANAGER, $data->rolesList)?"yes":"no"',
                'value'              => '',
                'headerHtmlOptions' => [
                    'style' => 'width: 200px;'
                ]
            ],
            [
                'name'  => Yii::t('manager', AuthManager::ROLE_PRODUCTS_MANAGER),
                'cssClassExpression' => 'in_array(AuthManager::ROLE_PRODUCTS_MANAGER, $data->rolesList)?"yes":"no"',
                'value'              => '',
                'headerHtmlOptions' => [
                    'style' => 'width: 200px;'
                ]
            ],
            [
                'name'  => Yii::t('manager', AuthManager::ROLE_CATEGORIES_MANAGER),
                'cssClassExpression' => 'in_array(AuthManager::ROLE_CATEGORIES_MANAGER, $data->rolesList)?"yes":"no"',
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
                            "managers/update",
                            ["shop_id" => $data->shop_id, "user_id" => $data->user_id]
                        ),
                        ["class" => "btn btn-default"]
                    ) . CHtml::link(
                        Yii::t("label", "delete"),
                        Yii::app()->urlManager->createUrl(
                            "managers/delete",
                            ["shop_id" => $data->shop_id, "user_id" => $data->user_id]
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