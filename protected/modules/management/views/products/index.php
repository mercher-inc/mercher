<?php
/* @var $this ProductsController */
/* @var $dataProvider CActiveDataProvider */

$this->menu=array(
	array('label'=>'Create Product', 'url'=>array('create')),
	array('label'=>'Manage Product', 'url'=>array('admin')),
);

$this->headerTitle = 'Products';

$this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
));