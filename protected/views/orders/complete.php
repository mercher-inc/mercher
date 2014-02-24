<?php
/**
 * @var $this ProductsController
 * @var $model Product
 * @var $form ActiveForm
 */

Yii::app()->controller->headerTitle = Yii::t('product', 'complete');

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

<div class="alert alert-info">
    <p>
        <strong>Do you really want to complete order #<?php echo $model->id ?>?</strong>
    </p>

    <p>
        <input type="submit" class="btn btn-primary" value="Yes">
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

