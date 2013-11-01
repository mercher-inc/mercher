<?php
/* @var $this UsersController */
/* @var $dataProvider CActiveDataProvider */

$this->menu=array(
	array('label'=>'Create User', 'url'=>array('create')),
	array('label'=>'Manage User', 'url'=>array('admin')),
);

$this->headerTitle = 'Users';

$this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
));
