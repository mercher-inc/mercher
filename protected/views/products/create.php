<?php
/**
 * @var $this ProductsController
 * @var $model Product
 * @var $form ActiveForm
 * @var $categoriesList array
 */

Yii::app()->controller->headerTitle = Yii::t(
    'product',
    'create'
);

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
        'title'       => Yii::t('product', 'help_title')
    ]
);
echo $form->error($model, 'title', ['class' => 'help-block']);
echo CHtml::closeTag('div');
echo CHtml::closeTag('div');

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
        'title'       => Yii::t('product', 'help_description')
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
        'title'       => Yii::t('product', 'help_category_id')
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
        'title'       => Yii::t('product', 'help_amount')
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
echo $form->label(
    $model,
    'is_active',
    [
        'class'       => 'control-label',
        'data-toggle' => 'tooltip',
        'title'       => Yii::t('product', 'help_is_active')
    ]
);
echo $form->checkBox(
    $model,
    'is_active',
    array(
        'uncheckValue' => 0
    )
);
echo $form->error($model, 'is_active', ['class' => 'help-block']);
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
        'class' => 'btn btn-primary'
    )
);
echo CHtml::closeTag('div');
echo CHtml::closeTag('div');

$this->endWidget();