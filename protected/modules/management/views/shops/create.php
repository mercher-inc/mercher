<?php
/* @var $this ShopsController */
/* @var $model Shop */

$this->menu=array(
	array('label'=>'List Shop', 'url'=>array('index')),
	array('label'=>'Manage Shop', 'url'=>array('admin')),
);

$this->headerTitle = 'Create Shop';

$this->renderPartial('_form', array('model'=>$model));