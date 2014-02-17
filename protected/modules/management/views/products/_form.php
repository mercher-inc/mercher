<?php
/* @var $this ProductsController */
/* @var $model Product */
/* @var $form CActiveForm */
?>

<div class="form">

    <?php $form = $this->beginWidget(
        'CActiveForm',
        array(
            'id'                   => 'product-form',
            'enableAjaxValidation' => false,
            'htmlOptions'          => [
                'class' => 'main-form'
            ]
        )
    ); ?>

    <p class="note">Fields with <span class="required">*</span> are required.</p>

    <?php echo $form->errorSummary($model); ?>

    <div class="row">
        <?php echo $form->labelEx($model, 'category_id'); ?>
        <?php echo $form->textField($model, 'category_id'); ?>
        <?php echo $form->error($model, 'category_id'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'title'); ?>
        <?php echo $form->textField($model, 'title', array('size' => 50, 'maxlength' => 50)); ?>
        <?php echo $form->error($model, 'title'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'description'); ?>
        <?php echo $form->textArea($model, 'description', array('rows' => 6, 'cols' => 50)); ?>
        <?php echo $form->error($model, 'description'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'image_id'); ?>
        <?php echo $form->textField($model, 'image_id'); ?>
        <?php echo $form->error($model, 'image_id'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'price'); ?>
        <?php echo $form->textField($model, 'price', array('size' => 9, 'maxlength' => 9)); ?>
        <?php echo $form->error($model, 'price'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'is_active'); ?>
        <?php echo $form->checkBox($model, 'is_active'); ?>
        <?php echo $form->error($model, 'is_active'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'is_banned'); ?>
        <?php echo $form->checkBox($model, 'is_banned'); ?>
        <?php echo $form->error($model, 'is_banned'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'quantity_in_stock'); ?>
        <?php echo $form->textField($model, 'quantity_in_stock'); ?>
        <?php echo $form->error($model, 'quantity_in_stock'); ?>
    </div>

    <div class="row buttons">
        <?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
    </div>

    <?php $this->endWidget(); ?>

</div><!-- form -->