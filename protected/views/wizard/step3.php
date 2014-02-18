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
echo CHtml::openTag('div', ['class' => 'form-group actions col-lg-12']);
echo CHtml::link('Next', $grantPermissionUrl, ['class' => 'btn btn-lg btn-warning', 'target'=>'_top']);
echo CHtml::closeTag('div');
echo CHtml::closeTag('div');

$this->endWidget();
