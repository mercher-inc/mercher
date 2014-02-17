<?php
/**
 * @var $this WizardController
 * @var $model Product
 * @var $shop Shop
 * @var $form ActiveForm
 */

$form = $this->beginWidget(
    'ActiveForm',
    [
        'id'                   => 'product-form',
        'enableAjaxValidation' => false,
        'htmlOptions'          => [
            'class'   => 'main-form',
            'enctype' => 'multipart/form-data'
        ]
    ]
);

Yii::app()->clientScript->registerPackage('bootstrap');
Yii::app()->clientScript->registerScript(
    'product-form-tooltips',
    "$('#product-form *[data-toggle=\"tooltip\"]').tooltip();"
);

echo CHtml::tag('legend', [], 'Add your first product');

echo CHtml::openTag('div', ['class' => 'row']);

//==image_id==
echo CHtml::openTag('div', ['class' => 'form-group col-lg-4' . ($model->hasErrors('image_id') ? ' has-error' : '')]);
echo $form->label($model, 'image_id', ['class' => 'control-label']);
$this->widget(
    'application.widgets.ImageUploadWidget',
    [
        'model'     => $model,
        'attribute' => 'image_id'
    ]
);
echo $form->error($model, 'image_id', ['class' => 'help-block']);
echo CHtml::closeTag('div');

echo CHtml::openTag('div', ['class' => 'col-lg-8']);

//==title==
echo CHtml::openTag('div', ['class' => 'row']);
echo CHtml::openTag('div', ['class' => 'form-group col-lg-12' . ($model->hasErrors('title') ? ' has-error' : '')]);
echo $form->label($model, 'title', ['class' => 'control-label']);
echo $form->textField(
    $model,
    'title',
    [
        'class'       => 'form-control',
        'data-toggle' => 'tooltip',
        'title'       => 'Provide the title of your first product'
    ]
);
echo $form->error($model, 'title', ['class' => 'help-block']);
echo CHtml::closeTag('div');
echo CHtml::closeTag('div');

//==description==
echo CHtml::openTag('div', ['class' => 'row']);
echo CHtml::openTag(
    'div',
    ['class' => 'form-group col-lg-12' . ($model->hasErrors('description') ? ' has-error' : '')]
);
echo $form->label($model, 'description', ['class' => 'control-label']);
echo $form->textArea(
    $model,
    'description',
    [
        'class'       => 'form-control',
        'data-toggle' => 'tooltip',
        'title'       => 'Provide the description of your first product'
    ]
);
echo $form->error($model, 'description', ['class' => 'help-block']);
echo CHtml::closeTag('div');
echo CHtml::closeTag('div');

//==price==
echo CHtml::openTag('div', ['class' => 'row']);
echo CHtml::openTag(
    'div',
    ['class' => 'form-group col-lg-12' . ($model->hasErrors('price') ? ' has-error' : '')]
);
echo $form->label($model, 'price', ['class' => 'control-label']);
echo $form->textField(
    $model,
    'price',
    [
        'class'       => 'form-control',
        'data-toggle' => 'tooltip',
        'title'       => 'Set product\'s price'
    ]
);
echo $form->error($model, 'price', ['class' => 'help-block']);
echo CHtml::closeTag('div');
echo CHtml::closeTag('div');


echo CHtml::closeTag('div');

echo CHtml::closeTag('div');


echo CHtml::openTag('div', ['class' => 'row']);
echo CHtml::openTag('div', ['class' => 'form-group actions col-lg-12']);
echo CHtml::submitButton('Next', ['class' => 'btn btn-lg btn-success']);
echo CHtml::link('Skip', $this->createUrl('step3'), ['class' => 'btn btn-lg btn-success-link']);
echo CHtml::closeTag('div');
echo CHtml::closeTag('div');

$this->endWidget();
