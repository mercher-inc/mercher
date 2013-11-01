<?php
/* @var $this ShopsController */
/* @var $model Shop */

$this->breadcrumbs=array(
	'Shops'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Shop', 'url'=>array('index')),
	array('label'=>'Manage Shop', 'url'=>array('admin')),
);
?>

<h1>Create Shop</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>