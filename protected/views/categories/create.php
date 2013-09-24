<?php
//==form==
echo CHtml::beginForm(
    $this->createUrl('categories/create', array('shop_id'=>$this->shop->id))
);
echo CHtml::tag(
    'legend',
    array(),
    Yii::t('category', 'create')
);

//==title==
echo CHtml::openTag(
    'div',
    array(
        'class' => 'form-group' . ($this->category->hasErrors('title') ? ' has-error' : '')
    )
);

echo CHtml::label(
    Yii::t('category', $this->category->getAttributeLabel('title')),
    'titleInput'
);
echo CHtml::textField(
    'title',
    $this->category->title,
    array(
        'class'       => 'form-control',
        'id'          => 'titleInput',
        'placeholder' => Yii::t('category', $this->category->getAttributeLabel('title'))
    )
);
echo CHtml::error(
    $this->category,
    'title',
    array(
        'class' => 'help-block'
    )
);
echo CHtml::closeTag('div');

//==description==
echo CHtml::openTag(
    'div',
    array(
        'class' => 'form-group' . ($this->category->hasErrors('description') ? ' has-error' : '')
    )
);
echo CHtml::label(
    Yii::t('category', $this->category->getAttributeLabel('description')),
    'descriptionInput'
);
echo CHtml::textArea(
    'description',
    $this->category->description,
    array(
        'class'       => 'form-control',
        'id'          => 'descriptionInput',
        'placeholder' => Yii::t('category', $this->category->getAttributeLabel('description')),
        'rows'        => 3
    )
);
echo CHtml::error(
    $this->category,
    'description',
    array(
        'class' => 'help-block'
    )
);
echo CHtml::closeTag('div');

//==is_active==
echo CHtml::openTag(
    'div',
    array(
        'class' => 'checkbox' . ($this->category->hasErrors('is_active') ? ' has-error' : '')
    )
);
echo CHtml::label(
    Yii::t('category', $this->category->getAttributeLabel('is_active')),
    'isActiveInput'
);
echo CHtml::checkBox(
    'is_active',
    $this->category->is_active,
    array(
        'id'           => 'isActiveInput',
        'uncheckValue' => 0
    )
);
echo CHtml::error(
    $this->category,
    'is_active',
    array(
        'class' => 'help-block'
    )
);
echo CHtml::closeTag('div');

//==submit==
echo CHtml::submitButton(
    Yii::t('category', 'save'),
    array(
        'class' => 'btn btn-default'
    )
);

echo CHtml::endForm();
?>