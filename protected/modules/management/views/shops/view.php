<?php
/* @var $this ShopsController */
/* @var $model Shop */

$this->menu=array(
	array('label'=>'List Shop', 'url'=>array('index')),
	array('label'=>'Create Shop', 'url'=>array('create')),
	array('label'=>'Update Shop', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete Shop', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Shop', 'url'=>array('admin')),
);

$this->headerTitle = 'View Shop';

$this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'created',
		'updated',
		'fb_id',
		'owner_id',
		'title',
		'description',
		'is_active',
		'is_banned',
		'pp_merchant_id',
		'tax',
	),
));