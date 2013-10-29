<?php
//==form==
echo CHtml::beginForm(
    $this->createUrl('products/update', array('shop_id' => $this->shop->id, 'product_id' => $this->product->id)),
    'post',
    array(
        'enctype' => 'multipart/form-data'
    )
);
echo CHtml::tag(
    'legend',
    array(),
    Yii::t('product', 'edit')
);

//==title==
echo CHtml::openTag(
    'div',
    array(
        'class' => 'form-group' . ($this->product->hasErrors('title') ? ' has-error' : '')
    )
);

echo CHtml::label(
    Yii::t('product', $this->product->getAttributeLabel('title')),
    'titleInput'
);
echo CHtml::textField(
    'title',
    $this->product->title,
    array(
        'class'       => 'form-control',
        'id'          => 'titleInput',
        'placeholder' => Yii::t('product', $this->product->getAttributeLabel('title'))
    )
);
echo CHtml::error(
    $this->product,
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
        'class' => 'form-group' . ($this->product->hasErrors('description') ? ' has-error' : '')
    )
);
echo CHtml::label(
    Yii::t('product', $this->product->getAttributeLabel('description')),
    'descriptionInput'
);
echo CHtml::textArea(
    'description',
    $this->product->description,
    array(
        'class'       => 'form-control',
        'id'          => 'descriptionInput',
        'placeholder' => Yii::t('product', $this->product->getAttributeLabel('description')),
        'rows'        => 3
    )
);
echo CHtml::error(
    $this->product,
    'description',
    array(
        'class' => 'help-block'
    )
);
echo CHtml::closeTag('div');

//==new_image==
echo CHtml::openTag(
    'div',
    array(
        'class' => 'form-group' . ($this->product->hasErrors('new_image') ? ' has-error' : '')
    )
);

echo CHtml::label(
    Yii::t('product', $this->product->getAttributeLabel('new_image')),
    'newImageInput'
);
echo CHtml::fileField(
    'new_image',
    '',
    array(
        'class' => 'form-control',
        'id'    => 'newImageInput'
    )
);
if ($this->product->image) {
    echo CHtml::hiddenField(
        'image_id',
        $this->product->image->id
    );
    $data = CJSON::decode($this->product->image->data);
    echo CHtml::image(
        $data['m'],
        '',
        array(
            'class' => 'img-thumbnail'
        )
    );
}
echo CHtml::error(
    $this->product,
    'new_image',
    array(
        'class' => 'help-block'
    )
);
echo CHtml::closeTag('div');

//==category_id==
echo CHtml::openTag(
    'div',
    array(
        'class' => 'form-group' . ($this->product->hasErrors('category_id') ? ' has-error' : '')
    )
);
echo CHtml::label(
    Yii::t('category', $this->product->getAttributeLabel('category_id')),
    'categoryIdInput'
);
$categoriesOptions = array(
    '' => Yii::t('category', 'not_set')
);
foreach ($this->shop->categories as $category) {
    $categoriesOptions[$category->id] = $category->title;
}
echo CHtml::dropDownList(
    'category_id',
    $this->product->category_id,
    $categoriesOptions,
    array(
        'class' => 'form-control',
        'id'    => 'categoryIdInput'
    )
);
echo CHtml::error(
    $this->product,
    'category_id',
    array(
        'class' => 'help-block'
    )
);
echo CHtml::closeTag('div');

//==amount==
echo CHtml::openTag(
    'div',
    array(
        'class' => 'form-group' . ($this->product->hasErrors('amount') ? ' has-error' : '')
    )
);

echo CHtml::label(
    Yii::t('product', $this->product->getAttributeLabel('amount')) . ', &#36;',
    'amountInput'
);
echo CHtml::textField(
    'amount',
    $this->product->amount,
    array(
        'class'       => 'form-control',
        'id'          => 'amountInput',
        'placeholder' => Yii::t('product', $this->product->getAttributeLabel('amount'))
    )
);
echo CHtml::error(
    $this->product,
    'amount',
    array(
        'class' => 'help-block'
    )
);
echo CHtml::closeTag('div');

//==is_active==
echo CHtml::openTag(
    'div',
    array(
        'class' => 'checkbox' . ($this->product->hasErrors('is_active') ? ' has-error' : '')
    )
);
echo CHtml::label(
    Yii::t('product', $this->product->getAttributeLabel('is_active')),
    'isActiveInput'
);
echo CHtml::checkBox(
    'is_active',
    $this->product->is_active,
    array(
        'id'           => 'isActiveInput',
        'uncheckValue' => 0
    )
);
echo CHtml::error(
    $this->product,
    'is_active',
    array(
        'class' => 'help-block'
    )
);
echo CHtml::closeTag('div');

//==submit==
echo CHtml::submitButton(
    Yii::t('product', 'save'),
    array(
        'class' => 'btn btn-default'
    )
);

echo CHtml::endForm();
?>