<?php
/* @var $this CategoriesController */
/* @var $model Category */

$this->menu=array(
	array('label'=>'List Category', 'url'=>array('index')),
	array('label'=>'Create Category', 'url'=>array('create')),
	array('label'=>'View Category', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage Category', 'url'=>array('admin')),
);

$this->headerTitle = 'Update Category';

$this->renderPartial('_form', array('model'=>$model));