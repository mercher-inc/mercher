<?php
/* @var $this WizardController */
/* @var $model Shop */
/* @var $form CActiveForm */

$form = $this->beginWidget(
    'CActiveForm',
    [
        'id'                   => 'shop-form',
        'enableAjaxValidation' => false,
        'htmlOptions'          => [
            'class' => 'main-form'
        ]
    ]
);

Yii::app()->clientScript->registerPackage('bootstrap');
Yii::app()->clientScript->registerScript('shop-form-tooltips', "$('#shop-form *[data-toggle=\"tooltip\"]').tooltip();");

echo CHtml::tag('legend', [], 'Select one of your Facebook pages to create shop for it and provide your PayPal ID');

$accounts = [];
$result   = Yii::app()->facebook->sdk->api('/me/accounts?fields=id,name&limit=50');
if (isset($result['data'])) {
    foreach ($result['data'] as $row) {
        $accounts[$row['id']] = $row['name'];
    }
}

echo CHtml::openTag('div', ['class' => 'row']);
echo CHtml::openTag('div', ['class' => 'form-group col-lg-12' . ($model->hasErrors('fb_id') ? ' has-error' : '')]);
echo $form->label($model, 'fb_id', ['class' => 'control-label']);
echo $form->dropDownList(
    $model,
    'fb_id',
    $accounts,
    [
        'class'       => 'form-control',
        'data-toggle' => 'tooltip',
        'title'       => 'Select one of your Facebook pages to create shop for'
    ]
);
echo $form->error($model, 'fb_id', ['class' => 'help-block']);
echo CHtml::closeTag('div');
echo CHtml::closeTag('div');

echo CHtml::openTag('div', ['class' => 'row']);
echo CHtml::openTag(
    'div',
    ['class' => 'form-group col-lg-12' . ($model->hasErrors('pp_merchant_id') ? ' has-error' : '')]
);
echo $form->label($model, 'pp_merchant_id', ['class' => 'control-label']);
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
echo CHtml::submitButton('Next', ['class' => 'btn btn-lg btn-danger']);
echo CHtml::closeTag('div');
echo CHtml::closeTag('div');

$this->endWidget();
