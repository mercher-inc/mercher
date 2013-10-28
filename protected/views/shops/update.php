<?php
//==form==
echo CHtml::beginForm(
    $this->createUrl('shops/update', array('shop_id' => $this->shop->id))
);
echo CHtml::tag(
    'legend',
    array(),
    Yii::t('shop', 'edit')
);

//==title==
echo CHtml::openTag(
    'div',
    array(
        'class' => 'form-group' . ($this->shop->hasErrors('title') ? ' has-error' : '')
    )
);

echo CHtml::label(
    Yii::t('shop', $this->shop->getAttributeLabel('title')),
    'titleInput'
);
echo CHtml::textField(
    'title',
    $this->shop->title,
    array(
        'class'       => 'form-control',
        'id'          => 'titleInput',
        'placeholder' => Yii::t('shop', $this->shop->getAttributeLabel('title'))
    )
);
echo CHtml::error(
    $this->shop,
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
        'class' => 'form-group' . ($this->shop->hasErrors('description') ? ' has-error' : '')
    )
);
echo CHtml::label(
    Yii::t('shop', $this->shop->getAttributeLabel('description')),
    'descriptionInput'
);
echo CHtml::textArea(
    'description',
    $this->shop->description,
    array(
        'class'       => 'form-control',
        'id'          => 'descriptionInput',
        'placeholder' => Yii::t('shop', $this->shop->getAttributeLabel('description')),
        'rows'        => 3
    )
);
echo CHtml::error(
    $this->shop,
    'description',
    array(
        'class' => 'help-block'
    )
);
echo CHtml::closeTag('div');

//==pp_merchant_id==
echo CHtml::openTag(
    'div',
    array(
        'class' => 'form-group' . ($this->shop->hasErrors('pp_merchant_id') ? ' has-error' : '')
    )
);

echo CHtml::label(
    Yii::t('shop', $this->shop->getAttributeLabel('pp_merchant_id')),
    'ppMerchantIdInput'
);
echo CHtml::textField(
    'pp_merchant_id',
    $this->shop->pp_merchant_id,
    array(
        'class'       => 'form-control',
        'id'          => 'ppMerchantIdInput',
        'placeholder' => Yii::t('shop', $this->shop->getAttributeLabel('pp_merchant_id'))
    )
);
echo CHtml::error(
    $this->shop,
    'pp_merchant_id',
    array(
        'class' => 'help-block'
    )
);
echo CHtml::closeTag('div');

//==is_active==
echo CHtml::openTag(
    'div',
    array(
        'class' => 'checkbox' . ($this->shop->hasErrors('is_active') ? ' has-error' : '')
    )
);
echo CHtml::label(
    Yii::t('shop', $this->shop->getAttributeLabel('is_active')),
    'isActiveInput'
);
echo CHtml::checkBox(
    'is_active',
    $this->shop->is_active,
    array(
        'id'           => 'isActiveInput',
        'uncheckValue' => 0
    )
);
echo CHtml::error(
    $this->shop,
    'is_active',
    array(
        'class' => 'help-block'
    )
);
echo CHtml::closeTag('div');

//==submit==
echo CHtml::submitButton(
    Yii::t('shop', 'save'),
    array(
        'class' => 'btn btn-default'
    )
);

echo CHtml::endForm();
?>