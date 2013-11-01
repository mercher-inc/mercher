<?php
/* @var $this WizardController */
/* @var $model Shop */
/* @var $form CActiveForm */
?>

<div class="container">
    <?php

    $form = $this->beginWidget(
        'CActiveForm',
        [
            'id'                   => 'shop-form',
            'enableAjaxValidation' => false
        ]
    );

    $accounts = [];
    $result = Yii::app()->facebook->sdk->api('/me/accounts?fields=id,name&limit=50');
    if (isset($result['data'])) {
        foreach ($result['data'] as $row) {
            $accounts[$row['id']] = $row['name'];
        }
    }

    echo CHtml::openTag('div', ['class'=>'form-group'.($model->hasErrors('fb_id')?' has-error':'')]);
    echo $form->label($model,'fb_id', ['class'=>'control-label']);
    echo $form->dropDownList(
        $model,
        'fb_id',
        $accounts,
        [
            'class' => 'form-control'
        ]
    );
    echo $form->error($model,'fb_id',['class'=>'help-block']);
    echo CHtml::closeTag('div');

    echo CHtml::submitButton('Next', ['class'=>'btn btn-lg btn-danger']);

    $this->endWidget();
    ?>

</div>