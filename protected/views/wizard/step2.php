<?php
/* @var $this WizardController */
/* @var $model Category */
/* @var $form CActiveForm */
?>

<div class="container">
    <?php

    $form = $this->beginWidget(
        'CActiveForm',
        [
            'id'                   => 'category-form',
            'enableAjaxValidation' => false
        ]
    );

    echo CHtml::openTag('div', ['class'=>'form-group'.($model->hasErrors('title')?' has-error':'')]);
    echo $form->label($model,'title', ['class'=>'control-label']);
    echo $form->textField(
        $model,
        'title',
        [
            'class' => 'form-control'
        ]
    );
    echo $form->error($model,'title',['class'=>'help-block']);
    echo CHtml::closeTag('div');

    echo CHtml::submitButton('Next', ['class'=>'btn btn-lg btn-success']);

    $this->endWidget();
    ?>

</div>