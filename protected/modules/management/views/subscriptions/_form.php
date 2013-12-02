<?php
/**
 * @var $this SubscriptionsController
 * @var $model Subscription
 * @var $form CActiveForm
 */
?>

<div class="form">

    <?php $form = $this->beginWidget(
        'CActiveForm',
        array(
            'id'                   => 'subscription-form',
            'enableAjaxValidation' => false,
            'htmlOptions'          => [
                'class' => 'main-form'
            ]
        )
    ); ?>

    <?php echo $form->errorSummary($model); ?>

    <div class="form-group">
        <?php echo $form->labelEx($model, 'title', ['class' => 'control-label']); ?>
        <?php echo $form->textField($model, 'title', ['class' => 'form-control']); ?>
        <?php echo $form->error($model, 'title'); ?>
    </div>

    <div class="form-group">
        <?php echo $form->labelEx($model, 'description', ['class' => 'control-label']); ?>
        <?php echo $form->textArea($model, 'description', ['class' => 'form-control']); ?>
        <?php echo $form->error($model, 'description'); ?>
    </div>

    <div class="form-group">
        <?php echo $form->labelEx($model, 'image', ['class' => 'control-label']); ?>
        <?php echo $form->textField($model, 'image', ['class' => 'form-control']); ?>
        <?php echo $form->error($model, 'image'); ?>
    </div>

    <div class="form-group">
        <?php echo $form->labelEx($model, 'price', ['class' => 'control-label']); ?>
        <?php echo $form->textField($model, 'price', ['class' => 'form-control']); ?>
        <?php echo $form->error($model, 'price'); ?>
    </div>

    <div class="form-group">
        <?php echo $form->labelEx($model, 'trial_duration', ['class' => 'control-label']); ?>
        <?php echo $form->textField($model, 'trial_duration', ['class' => 'form-control']); ?>
        <?php echo $form->error($model, 'trial_duration'); ?>
    </div>

    <div class="form-group">
        <?php echo $form->labelEx($model, 'products_count', ['class' => 'control-label']); ?>
        <?php echo $form->textField($model, 'products_count', ['class' => 'form-control']); ?>
        <?php echo $form->error($model, 'products_count'); ?>
    </div>

    <div class="checkbox">
        <?php echo $form->labelEx($model, 'is_public', ['class' => 'control-label']); ?>
        <?php echo $form->checkBox($model, 'is_public'); ?>
        <?php echo $form->error($model, 'is_public'); ?>
    </div>

    <div class="form-group actions">
        <?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save', ['class' => 'btn btn-primary']); ?>
    </div>

    <?php $this->endWidget(); ?>

</div><!-- form -->