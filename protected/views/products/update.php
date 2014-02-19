<?php
/**
 * @var $this ProductsController
 * @var $model Product
 * @var $form ActiveForm
 * @var $categoriesList array
 */

Yii::app()->controller->headerTitle = Yii::t('product', 'edit');

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

$messages = Yii::app()->user->getFlashes('Product');
if (count($messages)) {
    Yii::app()->clientScript->registerPackage('bootstrap');
}
foreach ($messages as $key => $message) {
    echo '<div class="alert alert-info"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>' . $message . "</div>\n";
}

Yii::app()->clientScript->registerPackage('bootstrap');
Yii::app()->clientScript->registerScript(
    'product-form-tooltips',
    "$('#product-form *[data-toggle=\"tooltip\"]').tooltip();"
);

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
        'title'       => Yii::t('product', 'help_title')
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
        'title'       => Yii::t('product', 'help_description')
    ]
);
echo $form->error($model, 'description', ['class' => 'help-block']);
echo CHtml::closeTag('div');
echo CHtml::closeTag('div');

//==category_id==
/*
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
*/

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
        'title'       => Yii::t('product', 'help_price')
    ]
);
echo $form->error($model, 'price', ['class' => 'help-block']);
echo CHtml::closeTag('div');
echo CHtml::closeTag('div');

//==quantity_in_stock==
echo CHtml::openTag('div', ['class' => 'row']);
echo CHtml::openTag(
    'div',
    ['class' => 'form-group col-lg-12' . ($model->hasErrors('quantity_in_stock') ? ' has-error' : '')]
);
echo $form->label($model, 'quantity_in_stock', ['class' => 'control-label']);
echo $form->numberField(
    $model,
    'quantity_in_stock',
    [
        'class'       => 'form-control',
        'data-toggle' => 'tooltip',
        'title'       => Yii::t('product', 'help_quantity_in_stock'),
        'placeholder'   => Yii::t('product', 'placeholder_quantity_in_stock'),
    ]
);
echo $form->error($model, 'quantity_in_stock', ['class' => 'help-block']);
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
echo $form->error($model, 'shop_id', ['class' => 'text-danger']);
echo CHtml::submitButton(
    Yii::t('product', 'save'),
    array(
        'class' => 'btn btn-primary'
    )
);
echo CHtml::closeTag('div');
echo CHtml::closeTag('div');

$this->endWidget();