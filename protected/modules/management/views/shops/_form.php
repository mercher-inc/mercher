<?php
/* @var $this ShopsController */
/* @var $model Shop */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'shop-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'created'); ?>
		<?php echo $form->textField($model,'created'); ?>
		<?php echo $form->error($model,'created'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'updated'); ?>
		<?php echo $form->textField($model,'updated'); ?>
		<?php echo $form->error($model,'updated'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'fb_id'); ?>
		<?php echo $form->textField($model,'fb_id'); ?>
		<?php echo $form->error($model,'fb_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'owner_id'); ?>
		<?php echo $form->textField($model,'owner_id'); ?>
		<?php echo $form->error($model,'owner_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'title'); ?>
		<?php echo $form->textField($model,'title',array('size'=>50,'maxlength'=>50)); ?>
		<?php echo $form->error($model,'title'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'description'); ?>
		<?php echo $form->textArea($model,'description',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'description'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'template_alias'); ?>
		<?php echo $form->textField($model,'template_alias',array('size'=>50,'maxlength'=>50)); ?>
		<?php echo $form->error($model,'template_alias'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'template_config'); ?>
		<?php echo $form->textArea($model,'template_config',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'template_config'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'is_active'); ?>
		<?php echo $form->checkBox($model,'is_active'); ?>
		<?php echo $form->error($model,'is_active'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'is_banned'); ?>
		<?php echo $form->checkBox($model,'is_banned'); ?>
		<?php echo $form->error($model,'is_banned'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'pp_merchant_id'); ?>
		<?php echo $form->textField($model,'pp_merchant_id',array('size'=>50,'maxlength'=>50)); ?>
		<?php echo $form->error($model,'pp_merchant_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'tax'); ?>
		<?php echo $form->textField($model,'tax',array('size'=>6,'maxlength'=>6)); ?>
		<?php echo $form->error($model,'tax'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->