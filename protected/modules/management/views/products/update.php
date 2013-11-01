<?php
/* @var $this ProductsController */
/* @var $model Product */

$this->menu=array(
	array('label'=>'List Product', 'url'=>array('index')),
	array('label'=>'Create Product', 'url'=>array('create')),
	array('label'=>'View Product', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage Product', 'url'=>array('admin')),
);

$this->headerTitle = 'Update Product';

$this->renderPartial('_form', array('model'=>$model));