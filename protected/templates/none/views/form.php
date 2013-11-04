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

//==per_page_count==
echo CHtml::openTag(
    'div',
    array(
        'class' => 'form-group' . ($this->template->form->hasErrors('per_page_count') ? ' has-error' : '')
    )
);

echo CHtml::label(
    $this->template->form->getAttributeLabel('per_page_count'),
    'perPageCountInput'
);

Yii::app()->clientScript->registerScript(
    'design-form-per_page_count',
    "
        $('.design-in-row-btn-r2c2 input, .design-in-row-btn-r3c3 input, .design-in-row-btn-r4c4 input', $('#design-form')).change(function(e){
            $('.design-in-row-btn-r2c2, .design-in-row-btn-r3c3, .design-in-row-btn-r4c4', $('#design-form')).removeClass('active');
            $(e.target).parent().addClass('active');
        });
    "
);

echo CHtml::openTag('div', ['class' => 'design-in-row-line row']);
$attr = 'per_page_count';
echo CHtml::openTag('label', ['class' => 'col-lg-4']);
echo CHtml::openTag('div', ['class' => 'design-in-row-btn-r2c2' . ($model->per_page_count == 4 ? ' active' : '')]);
echo CHtml::radioButton(CHtml::resolveName($model, $attr), $model->per_page_count == 4, ['value' => 4]);
echo CHtml::closeTag('div');
echo CHtml::closeTag('label');

echo CHtml::openTag('label', ['class' => 'col-lg-4']);
echo CHtml::openTag('div', ['class' => 'design-in-row-btn-r3c3' . ($model->per_page_count == 9 ? ' active' : '')]);
echo CHtml::radioButton(CHtml::resolveName($model, $attr), $model->per_page_count == 9, ['value' => 9]);
echo CHtml::closeTag('div');
echo CHtml::closeTag('label');

echo CHtml::openTag('label', ['class' => 'col-lg-4']);
echo CHtml::openTag('div', ['class' => 'design-in-row-btn-r4c4' . ($model->per_page_count == 16 ? ' active' : '')]);
echo CHtml::radioButton(CHtml::resolveName($model, $attr), $model->per_page_count == 16, ['value' => 16]);
echo CHtml::closeTag('div');
echo CHtml::closeTag('label');

echo CHtml::closeTag('div');

echo CHtml::error(
    $this->template->form,
    'per_page_count',
    array(
        'class' => 'help-block'
    )
);
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