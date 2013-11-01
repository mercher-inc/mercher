<?php
/* @var $this ProductsController */
/* @var $model Product */

$this->menu=array(
	array('label'=>'List Product', 'url'=>array('index')),
	array('label'=>'Manage Product', 'url'=>array('admin')),
);

$this->headerTitle = 'Create Product';

$this->renderPartial('_form', array('model'=>$model));