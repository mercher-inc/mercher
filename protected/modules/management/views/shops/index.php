<?php
/* @var $this ShopsController */
/* @var $dataProvider CActiveDataProvider */

$this->menu=array(
	array('label'=>'Create Shop', 'url'=>array('create')),
	array('label'=>'Manage Shop', 'url'=>array('admin')),
);

$this->headerTitle = 'Shops';

$this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
));
