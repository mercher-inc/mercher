<?php
/**
 * @var $this WizardController
 * @var $model Shop
 * @var $form ActiveForm
 */

$form = $this->beginWidget(
    'ActiveForm',
    [
        'id'                   => 'shop-form',
        'enableAjaxValidation' => false,
        'htmlOptions'          => [
            'class'   => 'main-form'
        ]
    ]
);

Yii::app()->clientScript->registerPackage('bootstrap');
Yii::app()->clientScript->registerScript(
    'shop-form-tooltips',
    "$('#shop-form *[data-toggle=\"tooltip\"]').tooltip();"
);

echo CHtml::tag('legend', [], 'Provide your PayPal ID');


echo CHtml::openTag('div', ['class' => 'row']);
echo CHtml::openTag(
    'div',
    ['class' => 'form-group col-lg-12' . ($model->hasErrors('pp_merchant_id') ? ' has-error' : '')]
);
echo $form->textField(
    $model,
    'pp_merchant_id',
    [
        'class'       => 'form-control',
        'data-toggle' => 'tooltip',
        'title'       => 'Provide your PayPal merchant email'
    ]
);
echo $form->error($model, 'pp_merchant_id', ['class' => 'help-block']);
echo CHtml::closeTag('div');
echo CHtml::closeTag('div');

echo CHtml::openTag('div', ['class' => 'row']);
echo CHtml::openTag('div', ['class' => 'form-group actions col-lg-12']);
echo CHtml::submitButton('Next', ['class' => 'btn btn-lg btn-warning']);
echo CHtml::closeTag('div');
echo CHtml::closeTag('div');

$this->endWidget();
