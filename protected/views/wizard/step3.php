<?php
/**
 * @var $this WizardController
 * @var $model Product
 * @var $shop Shop
 * @var $category Category
 * @var $categoriesList array
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

echo CHtml::openTag('div', ['class' => 'row']);

//==new_image==
echo CHtml::openTag('div', ['class' => 'form-group col-lg-4' . ($model->hasErrors('new_image') ? ' has-error' : '')]);
echo $form->label($model, 'new_image', ['class' => 'control-label']);
echo $form->imageField(
    $model,
    'new_image',
    [
        'data-toggle' => 'tooltip',
        'title'       => 'Provide an image for your first product'
    ],
    'image_id'
);
echo $form->error($model, 'new_image', ['class' => 'help-block']);
echo CHtml::closeTag('div');

echo CHtml::openTag('div', ['class' => 'col-lg-8']);

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

//==category_id==
echo CHtml::openTag('div', ['class' => 'row']);
echo CHtml::openTag(
    'div',
    ['class' => 'form-group col-lg-12' . ($model->hasErrors('category_id') ? ' has-error' : '')]
);
echo $form->label($model, 'category_id', ['class' => 'control-label']);
echo $form->dropDownList(
    $model,
    'category_id',
    $categoriesList,
    [
        'class'       => 'form-control',
        'data-toggle' => 'tooltip',
        'title'       => 'Select one of categories for the product'
    ]
);
echo $form->error($model, 'category_id', ['class' => 'help-block']);
echo CHtml::closeTag('div');
echo CHtml::closeTag('div');

//==amount==
echo CHtml::openTag('div', ['class' => 'row']);
echo CHtml::openTag(
    'div',
    ['class' => 'form-group col-lg-12' . ($model->hasErrors('amount') ? ' has-error' : '')]
);
echo $form->label($model, 'amount', ['class' => 'control-label']);
echo $form->textField(
    $model,
    'amount',
    [
        'class'       => 'form-control',
        'data-toggle' => 'tooltip',
        'title'       => 'Set product\'s amount'
    ]
);
echo $form->error($model, 'amount', ['class' => 'help-block']);
echo CHtml::closeTag('div');
echo CHtml::closeTag('div');


echo CHtml::closeTag('div');

echo CHtml::closeTag('div');


echo CHtml::openTag('div', ['class' => 'row']);
echo CHtml::openTag('div', ['class' => 'form-group actions col-lg-12']);
echo CHtml::submitButton('Next', ['class' => 'btn btn-lg btn-warning']);
echo CHtml::link('Skip', $this->createUrl('step4'), ['class' => 'btn btn-lg btn-warning-link']);
echo CHtml::closeTag('div');
echo CHtml::closeTag('div');

$this->endWidget();
