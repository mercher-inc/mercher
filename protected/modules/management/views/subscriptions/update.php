<?php
/* @var $this SubscriptionController */
/* @var $model Subscription */

$this->breadcrumbs = array(
    'Subscriptions' => array('index'),
    $model->title   => array('view', 'id' => $model->id),
    'Update',
);

$this->menu = array(
    array('label' => 'List Subscription', 'url' => array('index')),
    array('label' => 'Create Subscription', 'url' => array('create')),
    array('label' => 'View Subscription', 'url' => array('view', 'id' => $model->id)),
    array('label' => 'Manage Subscription', 'url' => array('admin')),
);

Yii::app()->controller->headerTitle = Yii::t(
    'subscription',
    'update',
    [
        '{title}' => $model->title
    ]
);
?>

<?php $this->renderPartial('_form', array('model' => $model)); ?>