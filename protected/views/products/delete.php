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
            'class'   => 'main-form'
        ]
    ]
);
?>

<div class="alert alert-danger">
    <p>
        Do you really want to delete product "<?php echo $model->title ?>"?
    </p>
    <p>
        <input type="hidden" name="_method" value="DELETE">
        <input type="submit" class="btn btn-danger" value="Yes">
        <?= CHtml::link('No', $this->createUrl('index', ['shop_id'=>$this->shop->id]), ['class'=>'btn btn-default']) ?>
    </p>
</div>

<?php
$this->endWidget();
?>

