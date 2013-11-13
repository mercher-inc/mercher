<?php
/* @var $this SubscriptionsController */
/* @var $model Subscription */

$this->menu = array(
    array('label' => 'List Subscriptions', 'url' => array('index')),
    array('label' => 'Create Subscriptions', 'url' => array('create')),
);

$this->headerTitle = 'Manage Subscriptions';

$this->renderPartial(
    '_search',
    array(
        'model' => $model,
    )
);

$this->widget(
    'application.widgets.grid.GridView',
    array(
        'id'           => 'subscription-grid',
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
                'name' => 'image',
                'type' => 'image'
            ],
            'price',
            'trial_duration',
            'products_count',
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