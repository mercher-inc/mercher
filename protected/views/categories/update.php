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

$messages = Yii::app()->user->getFlashes('Category');
if (count($messages)) {
    Yii::app()->clientScript->registerPackage('bootstrap');
}
foreach ($messages as $key => $message) {
    echo '<div class="alert alert-info"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>' . $message . "</div>\n";
}

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
        'title'       => Yii::t('category', 'help_title')
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
        'title'       => Yii::t('category', 'help_description')
    ]
);
echo $form->error($model, 'description', ['class' => 'help-block']);
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
echo $form->label(
    $model,
    'is_active',
    [
        'class'       => 'control-label',
        'data-toggle' => 'tooltip',
        'title'       => Yii::t('category', 'help_is_active')
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

//==submit==
echo CHtml::openTag('div', ['class' => 'row']);
echo CHtml::openTag('div', ['class' => 'form-group actions col-lg-12']);
echo CHtml::submitButton(Yii::t('category', 'save'), ['class' => 'btn btn-primary']);
echo CHtml::closeTag('div');
echo CHtml::closeTag('div');

$this->endWidget();