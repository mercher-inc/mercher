<?php
//==form==
echo CHtml::beginForm(
    Yii::app()->urlManager->createUrl('design/index', array('shop_id' => $this->template->shop->id))
);

Yii::app()->controller->headerTitle = Yii::t('label', 'design');

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
echo CHtml::dropDownList(
    'per_page_count',
    $this->template->form->per_page_count,
    array(
        '4'  => '2 in row, 2 rows',
        '9'  => '3 in row, 3 rows',
        '16' => '4 in row, 4 rows'
    ),
    array(
        'class' => 'form-control',
        'id'    => 'perPageCountInput'
    )
);
echo CHtml::error(
    $this->template->form,
    'per_page_count',
    array(
        'class' => 'help-block'
    )
);
echo CHtml::closeTag('div');

//==primary_color==
echo CHtml::openTag(
    'div',
    array(
        'class' => 'form-group' . ($this->template->form->hasErrors('primary_color') ? ' has-error' : '')
    )
);

echo CHtml::label(
    $this->template->form->getAttributeLabel('primary_color'),
    'primaryColorInput'
);
echo CHtml::textField(
    'primary_color',
    $this->template->form->primary_color,
    array(
        'class' => 'form-control',
        'id'    => 'primaryColorInput'
    )
);
echo CHtml::error(
    $this->template->form,
    'primary_color',
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