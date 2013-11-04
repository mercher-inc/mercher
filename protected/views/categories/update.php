<?php
/**
 * @var $this CategoriesController
 * @var $model Category
 * @var $form CActiveForm
 */

Yii::app()->controller->headerTitle = Yii::t('category', 'edit');

$form = $this->beginWidget(
    'CActiveForm',
    [
        'id'                   => 'category-form',
        'enableAjaxValidation' => false,
        'htmlOptions'          => [
            'class' => 'main-form'
        ]
    ]
);

Yii::app()->clientScript->registerPackage('bootstrap');
Yii::app()->clientScript->registerScript(
    'category-form-tooltips',
    "$('#category-form *[data-toggle=\"tooltip\"]').tooltip();"
);

echo CHtml::openTag('div', ['class' => 'row']);
echo CHtml::openTag('div', ['class' => 'form-group col-lg-12' . ($model->hasErrors('title') ? ' has-error' : '')]);
echo $form->label($model, 'title', ['class' => 'control-label']);
echo $form->textField(
    $model,
    'title',
    [
        'class'       => 'form-control',
        'data-toggle' => 'tooltip',
        'title'       => 'Provide the title of category'
    ]
);
echo $form->error($model, 'title', ['class' => 'help-block']);
echo CHtml::closeTag('div');
echo CHtml::closeTag('div');

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
        'title'       => 'Provide the description of category'
    ]
);
echo $form->error($model, 'description', ['class' => 'help-block']);
echo CHtml::closeTag('div');
echo CHtml::closeTag('div');

echo CHtml::openTag('div', ['class' => 'row']);
echo CHtml::openTag('div', ['class' => 'form-group actions col-lg-12']);
echo CHtml::submitButton(Yii::t('category', 'save'), ['class' => 'btn btn-primary']);
echo CHtml::closeTag('div');
echo CHtml::closeTag('div');

$this->endWidget();