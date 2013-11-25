<?php
/**
 * @var $this DesignController
 * @var $form CActiveForm
 * @var $model CFormModel
 */

Yii::app()->controller->headerTitle = Yii::t('label', 'design');

$form = $this->beginWidget(
    'ActiveForm',
    [
        'id'                   => 'design-form',
        'enableAjaxValidation' => false,
        'htmlOptions'          => [
            'class'   => 'main-form',
            'enctype' => 'multipart/form-data'
        ]
    ]
);

$messages = Yii::app()->user->getFlashes('templates_none_Form');
if (count($messages)) {
    Yii::app()->clientScript->registerPackage('bootstrap');
}
foreach ($messages as $key => $message) {
    echo '<div class="alert alert-info"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>' . $message . "</div>\n";
}

$model = $this->template->form;

//==primary_color==
echo CHtml::openTag('div', ['class' => 'row']);
echo CHtml::openTag(
    'div',
    ['class' => 'form-group col-lg-12' . ($model->hasErrors('primary_color') ? ' has-error' : '')]
);
echo $form->label($model, 'primary_color', ['class' => 'control-label']);
echo $form->textField(
    $model,
    'primary_color',
    [
        'class'         => 'form-control',
        'data-toggle'   => 'tooltip',
        'primary_color' => 'Provide the primary_color of your first product',
        'placeholder'   => '#3DA3A7'
    ]
);
echo $form->error($model, 'primary_color', ['class' => 'help-block']);
echo CHtml::closeTag('div');
echo CHtml::closeTag('div');

//==submit==
echo CHtml::openTag('div', ['class' => 'row']);
echo CHtml::openTag('div', ['class' => 'form-group actions col-lg-12']);
echo CHtml::submitButton(
    Yii::t('design', 'save'),
    array(
        'class' => 'btn btn-primary'
    )
);
echo CHtml::closeTag('div');
echo CHtml::closeTag('div');

$this->endWidget();