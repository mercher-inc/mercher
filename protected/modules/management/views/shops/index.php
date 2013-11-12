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
            'title',
            [
                'name' => 'description',
                'htmlOptions' => [
                    'style'=>'overflow: hidden; max-width: 150px; text-overflow: ellipsis;'
                ]
            ],
            [
                'name' => 'fb_id',
                'value'=> 'CHtml::link($data->fb_id, "https://www.facebook.com/".$data->fb_id, ["target"=>"_blank"])',
                'type' => 'raw'
            ],
            [
                'name' => 'owner_id',
                'value'=> 'CHtml::link($data->owner->first_name . " " . $data->owner->last_name, Yii::app()->urlManager->createUrl("management/users/view", ["id"=>$data->owner_id]))',
                'type' => 'raw'
            ],
            'tax',
            [
                'name' => 'pp_merchant_id',
                'type' => 'email'
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