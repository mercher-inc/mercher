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
            'created',
            'updated',
            'fb_id',
            'email',
            'first_name',
            'last_name',
            'is_banned',
            'last_login',
            array(
                'class' => 'CButtonColumn',
            ),
        ),
    )
);