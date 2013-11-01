<?php
/* @var $this UsersController */
/* @var $model User */

$this->menu=array(
	array('label'=>'List User', 'url'=>array('index')),
	array('label'=>'Create User', 'url'=>array('create')),
	array('label'=>'View User', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage User', 'url'=>array('admin')),
);

$this->headerTitle = 'Update User';

$this->renderPartial('_form', array('model'=>$model));