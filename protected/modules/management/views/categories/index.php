<?php
/* @var $this CategoriesController */
/* @var $dataProvider CActiveDataProvider */

$this->menu=array(
	array('label'=>'Create Category', 'url'=>array('create')),
	array('label'=>'Manage Category', 'url'=>array('admin')),
);

$this->headerTitle = 'Categories';

$this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
));