<?php
//==form==
echo CHtml::beginForm(
    Yii::app()->urlManager->createUrl('design/index', array('shop_id' => $this->template->shop->id))
);

echo CHtml::tag(
    'legend',
    array(),
    Yii::t('shop', 'design')
);

//==title==
echo CHtml::openTag(
    'div',
    array(
        'class' => 'form-group' . ($this->template->form->hasErrors('title') ? ' has-error' : '')
    )
);

echo CHtml::label(
    $this->template->form->getAttributeLabel('title'),
    'titleInput'
);
echo CHtml::textField(
    'title',
    $this->template->form->title,
    array(
        'class' => 'form-control',
        'id'    => 'titleInput'
    )
);
echo CHtml::error(
    $this->template->form,
    'title',
    array(
        'class' => 'help-block'
    )
);
echo CHtml::closeTag('div');

//==bg_color==
echo CHtml::openTag(
    'div',
    array(
        'class' => 'form-group' . ($this->template->form->hasErrors('bg_color') ? ' has-error' : '')
    )
);

echo CHtml::label(
    $this->template->form->getAttributeLabel('bg_color'),
    'bgColorInput'
);
echo CHtml::textField(
    'bg_color',
    $this->template->form->bg_color,
    array(
        'class' => 'form-control',
        'id'    => 'bgColorInput'
    )
);
echo CHtml::error(
    $this->template->form,
    'bg_color',
    array(
        'class' => 'help-block'
    )
);
echo CHtml::closeTag('div');

//==submit==
echo CHtml::submitButton(
    Yii::t('design', 'save'),
    array(
        'class' => 'btn btn-default'
    )
);

echo CHtml::endForm();