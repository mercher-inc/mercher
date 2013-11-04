<?php
/**
 * @var $this ShopsController
 * @var $model Shop
 * @var $form CActiveForm
 */

Yii::app()->controller->headerTitle = Yii::t('shop', 'edit');

$form = $this->beginWidget(
    'ActiveForm',
    [
        'id'                   => 'shop-form',
        'enableAjaxValidation' => false,
        'htmlOptions'          => [
            'class' => 'main-form',
        ]
    ]
);

$messages = Yii::app()->user->getFlashes('Shop');
if (count($messages)) {
    Yii::app()->clientScript->registerPackage('bootstrap');
}
foreach ($messages as $key => $message) {
    echo '<div class="alert alert-info"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>' . $message . "</div>\n";
}

Yii::app()->clientScript->registerPackage('bootstrap');
Yii::app()->clientScript->registerScript(
    'shop-form-tooltips',
    "$('#shop-form *[data-toggle=\"tooltip\"]').tooltip();"
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

echo CHtml::openTag('div', ['class' => 'col-lg-6']);

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
        'rows'        => 7,
        'data-toggle' => 'tooltip',
        'title'       => 'Provide the description of your first product'
    ]
);
echo $form->error($model, 'description', ['class' => 'help-block']);
echo CHtml::closeTag('div');
echo CHtml::closeTag('div');

echo CHtml::closeTag('div');

echo CHtml::openTag('div', ['class' => 'col-lg-6']);

//==tax==
echo CHtml::openTag('div', ['class' => 'row']);
echo CHtml::openTag('div', ['class' => 'form-group col-lg-12' . ($model->hasErrors('tax') ? ' has-error' : '')]);
echo $form->label($model, 'tax', ['class' => 'control-label']);
echo $form->textField(
    $model,
    'tax',
    [
        'class'       => 'form-control',
        'data-toggle' => 'tooltip',
        'title'       => 'Provide the tax of your first product'
    ]
);
echo $form->error($model, 'tax', ['class' => 'help-block']);
echo CHtml::closeTag('div');
echo CHtml::closeTag('div');

//==pp_merchant_id==
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
        'title'       => 'Provide the pp_merchant_id of your first product'
    ]
);
echo $form->error($model, 'pp_merchant_id', ['class' => 'help-block']);
echo CHtml::closeTag('div');
echo CHtml::closeTag('div');

//==is_active==
echo CHtml::openTag('div', ['class' => 'row']);
echo CHtml::openTag('div', ['class' => 'col-lg-12']);
echo CHtml::openTag(
    'div',
    array(
        'class' => 'checkbox' . ($model->hasErrors('is_active') ? ' has-error' : '')
    )
);
echo CHtml::label(
    Yii::t('product', $model->getAttributeLabel('is_active')),
    'isActiveInput'
);
echo CHtml::checkBox(
    'is_active',
    $model->is_active,
    array(
        'id'           => 'isActiveInput',
        'uncheckValue' => 0
    )
);
echo CHtml::error(
    $model,
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
    Yii::t('shop', 'save'),
    array(
        'class' => 'btn btn-primary'
    )
);
echo CHtml::closeTag('div');
echo CHtml::closeTag('div');

$this->endWidget();