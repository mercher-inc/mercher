<?php
/* @var $this UsersController */
/* @var $model User */

$this->menu=array(
    array('label'=>'List User', 'url'=>array('index')),
    array('label'=>'Manage User', 'url'=>array('admin')),
);

$this->headerTitle = 'Create User';

$this->renderPartial('_form', array('model'=>$model));