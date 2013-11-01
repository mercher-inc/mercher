<?php
/* @var $this ShopsController */
/* @var $model Shop */

$this->menu=array(
	array('label'=>'List Shop', 'url'=>array('index')),
	array('label'=>'Create Shop', 'url'=>array('create')),
	array('label'=>'View Shop', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage Shop', 'url'=>array('admin')),
);

$this->headerTitle = 'Update Shop';

$this->renderPartial('_form', array('model'=>$model));