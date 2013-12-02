<?php
/* @var $this SubscriptionController */
/* @var $model Subscription */

$this->breadcrumbs=array(
	'Subscriptions'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Subscription', 'url'=>array('index')),
	array('label'=>'Manage Subscription', 'url'=>array('admin')),
);

Yii::app()->controller->headerTitle = Yii::t(
    'subscription',
    'create'
);
?>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>