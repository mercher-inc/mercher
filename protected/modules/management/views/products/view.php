<?php
/* @var $this ProductsController */
/* @var $model Product */

$this->menu=array(
	array('label'=>'List Product', 'url'=>array('index')),
	array('label'=>'Create Product', 'url'=>array('create')),
	array('label'=>'Update Product', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete Product', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Product', 'url'=>array('admin')),
);

$this->headerTitle = 'View Product';

$this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'created',
		'updated',
		'fb_id',
		'shop_id',
		'category_id',
		'title',
		'description',
		'image_id',
		'amount',
		'is_active',
		'is_banned',
		'quantity_in_stock',
	),
));