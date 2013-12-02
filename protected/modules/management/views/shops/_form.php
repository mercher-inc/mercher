<?php
/**
 * @var $this ShopsController
 * @var $model Shop
 * @var $form CActiveForm
 */
?>

<div class="form">

    <?php $form = $this->beginWidget(
        'CActiveForm',
        array(
            'id'                   => 'shop-form',
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
        <?php echo $form->labelEx($model, 'tax', ['class' => 'control-label']); ?>
        <?php echo $form->textField($model, 'tax', ['class' => 'form-control']); ?>
        <?php echo $form->error($model, 'tax'); ?>
    </div>

    <div class="form-group">
        <?php echo $form->labelEx($model, 'pp_merchant_id', ['class' => 'control-label']); ?>
        <?php echo $form->textField($model, 'pp_merchant_id', ['class' => 'form-control']); ?>
        <?php echo $form->error($model, 'pp_merchant_id'); ?>
    </div>

    <div class="form-group">
        <?php echo $form->labelEx($model, 'ga_id', ['class' => 'control-label']); ?>
        <?php echo $form->textField($model, 'ga_id', ['class' => 'form-control']); ?>
        <?php echo $form->error($model, 'ga_id'); ?>
    </div>

    <div class="checkbox">
        <?php echo $form->labelEx($model, 'is_active', ['class' => 'control-label']); ?>
        <?php echo $form->checkBox($model, 'is_active'); ?>
        <?php echo $form->error($model, 'is_active'); ?>
    </div>

    <hr>

    <?php
        $subscriptions = [
            ''  => 'Free'
        ];
        foreach (Subscription::model()->findAll() as $subscription) {
            $subscriptions[$subscription->id]   = $subscription->title;
        }
    ?>

    <div class="form-group">
        <?php echo $form->labelEx($model, 'subscription_id', ['class' => 'control-label']); ?>
        <?php echo $form->dropDownList($model, 'subscription_id', $subscriptions, ['class' => 'form-control']); ?>
        <?php echo $form->error($model, 'subscription_id'); ?>
    </div>

    <div class="checkbox">
        <?php echo $form->labelEx($model, 'is_banned', ['class' => 'control-label']); ?>
        <?php echo $form->checkBox($model, 'is_banned'); ?>
        <?php echo $form->error($model, 'is_banned'); ?>
    </div>

    <div class="form-group actions">
        <?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save', ['class' => 'btn btn-primary']); ?>
    </div>

    <?php $this->endWidget(); ?>

</div><!-- form -->