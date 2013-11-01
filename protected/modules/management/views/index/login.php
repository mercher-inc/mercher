<?php
/**
 * @var $form CActiveForm
 * @var $model LoginForm
 */
?>

<div class="container">
<?php $form=$this->beginWidget('CActiveForm', ['htmlOptions'=>['style'=>'margin: 100px 0;']]); ?>

<div class="form-group<?php echo $model->hasErrors('password')?' has-error':'' ?>">
    <?php echo $form->label($model,'password', ['class'=>'control-label']); ?>
	<?php echo $form->passwordField($model,'password', ['class'=>"form-control"]); ?>
    <?php echo $form->error($model,'password',['class'=>'help-block']); ?>
</div>
<?php echo CHtml::submitButton('Enter', ['class'=>'btn btn-default']); ?>

<?php $this->endWidget(); ?>
</div><!-- form -->
