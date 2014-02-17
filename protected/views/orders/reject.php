<?php
/**
 * @var $this ProductsController
 * @var $model Product
 * @var $form ActiveForm
 */

Yii::app()->controller->headerTitle = Yii::t('product', 'delete');

$form = $this->beginWidget(
    'ActiveForm',
    [
        'id'                   => 'product-delete-form',
        'enableAjaxValidation' => false,
        'htmlOptions'          => [
            'class'  => 'main-form',
            'method' => 'post'
        ]
    ]
);
?>

<div class="alert alert-danger">
    <p>
        <strong>Do you really want to reject order #<?php echo $model->id ?>?</strong>
        If you will, you would not receive money from user.
    </p>
    <p>
        <input type="submit" class="btn btn-danger" value="Yes">
        <?= CHtml::link(
            'No',
            $this->createUrl('index', ['shop_id' => $this->shop->id]),
            ['class' => 'btn btn-default']
        ) ?>
    </p>
</div>

<?php
$this->endWidget();
?>

