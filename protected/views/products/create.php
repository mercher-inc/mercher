<?php
/**
 * @var $this ProductsController
 * @var $model Product
 * @var $form CActiveForm
 * @var $categoriesList array
 */

Yii::app()->controller->headerTitle = Yii::t('product', 'create');

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

//==is_active==
echo CHtml::openTag('div', ['class' => 'row']);
echo CHtml::openTag('div', ['class' => 'col-lg-12']);
echo CHtml::openTag(
    'div',
    array(
        'class' => 'checkbox' . ($this->product->hasErrors('is_active') ? ' has-error' : '')
    )
);
echo CHtml::label(
    Yii::t('product', $this->product->getAttributeLabel('is_active')),
    'isActiveInput'
);
echo CHtml::checkBox(
    'is_active',
    $this->product->is_active,
    array(
        'id'           => 'isActiveInput',
        'uncheckValue' => 0
    )
);
echo CHtml::error(
    $this->product,
    'is_active',
    array(
        'class' => 'help-block'
    )
);
echo CHtml::closeTag('div');
echo CHtml::closeTag('div');
echo CHtml::closeTag('div');


echo CHtml::closeTag('div');

echo CHtml::closeTag('div');

//==submit==

echo CHtml::openTag('div', ['class' => 'row']);
echo CHtml::openTag('div', ['class' => 'form-group actions col-lg-12']);
echo CHtml::submitButton(
    Yii::t('product', 'create'),
    array(
        'class' => 'btn btn-lg btn-primary'
    )
);
echo CHtml::closeTag('div');
echo CHtml::closeTag('div');

$this->endWidget();