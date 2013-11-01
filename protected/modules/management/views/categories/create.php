<?php
/* @var $this CategoriesController */
/* @var $model Category */

$this->menu=array(
	array('label'=>'List Category', 'url'=>array('index')),
	array('label'=>'Manage Category', 'url'=>array('admin')),
);

$this->headerTitle = 'Create Category';

$this->renderPartial('_form', array('model'=>$model));