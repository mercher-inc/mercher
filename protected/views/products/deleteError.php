<?php
/**
 * @var $this ProductsController
 * @var $model Product
 * @var $form ActiveForm
 */

Yii::app()->controller->headerTitle = Yii::t('product', 'delete');
?>
<div class="main-form">

<div class="alert alert-danger">
    <p>
        <strong>You can't delete "<?php echo $model->title ?>"!</strong>
        Users already ordered this product, hide it in shop instead.
    </p>
    <p>
        <?= CHtml::link('Return to products', $this->createUrl('index', ['shop_id'=>$this->shop->id]), ['class'=>'btn btn-default']) ?>
    </p>
</div>
</div>