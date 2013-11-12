<?php
/* @var $this UsersController */
/* @var $model User */

$this->menu = array(
    array('label' => 'List User', 'url' => array('index')),
    array('label' => 'Create User', 'url' => array('create')),
);

$this->headerTitle = 'Manage Users';

$this->renderPartial(
    '_search',
    array(
        'model' => $model,
    )
);

$this->widget(
    'application.widgets.grid.GridView',
    array(
        'id'           => 'user-grid',
        'dataProvider' => $model->search(),
        'columns'      => array(
            'id',
            'first_name',
            'last_name',
            [
                'name' => 'last_login',
                'type' => 'datetime'
            ],
            [
                'name' => 'fb_id',
                'value'=> 'CHtml::link($data->fb_id, "https://www.facebook.com/".$data->fb_id, ["target"=>"_blank"])',
                'type' => 'raw'
            ],
            [
                'name' => 'email',
                'type' => 'email'
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