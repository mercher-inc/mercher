<?php
/* @var $this SubscriptionController */
/* @var $model Subscription */

$this->breadcrumbs = array(
    'Subscriptions' => array('index'),
    $model->title,
);

$this->menu = array(
    array('label' => 'List Subscription', 'url' => array('index')),
    array('label' => 'Create Subscription', 'url' => array('create')),
    array('label' => 'Update Subscription', 'url' => array('update', 'id' => $model->id)),
    array('label'       => 'Delete Subscription',
          'url'         => '#',
          'linkOptions' => array('submit'  => array('delete', 'id' => $model->id),
                                 'confirm' => 'Are you sure you want to delete this item?'
          )
    ),
    array('label' => 'Manage Subscription', 'url' => array('admin')),
);
?>

    <h1>View Subscription #<?php echo $model->id; ?></h1>

<?php $this->widget(
    'zii.widgets.CDetailView',
    array(
        'data'       => $model,
        'attributes' => array(
            'id',
            'created',
            'updated',
            'title',
            'description',
            'image',
            'price',
            'trial_duration',
            'products_count',
        ),
    )
); ?>

<?php
echo CHtml::tag('button', ['class' => 'btn btn-success', 'id' => 'testSubscription'], 'Subscribe');
Yii::app()->clientScript->registerScript(
    'testSubscription',
    '
        $("#testSubscription").click(function(e){
            var obj = ' . CJSON::encode(
        [
            'method'  => 'pay',
            'action'  => 'create_subscription',
            'product' => $this->createAbsoluteUrl('/og/subscription/', ['subscription_id' => $model->id])
        ]
    ) . ';
            FB.ui(obj);
            console.log(e.target);
        });
    ',
    ClientScript::POS_FB
);
?>