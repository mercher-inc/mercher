<?php
/* @var $this ProductsWidget */
/* @var $product Product */

echo CHtml::openTag('div', ['class' => 'row']);

echo CHtml::tag('div', ['class' => 'col-lg-1 col-md-1 gridCell'], $product->id);
echo CHtml::tag(
    'div',
    ['class' => 'col-lg-1 col-md-1 gridCell'],
    $product->image_id ? CHtml::image($product->image->getSize('s'), '', ['class' => 'img-thumbnail']) : ''
);
echo CHtml::tag('div', ['class' => 'col-lg-2 col-md-2 gridCell'], $product->title);
echo CHtml::tag('div', ['class' => 'col-lg-1 col-md-1 gridCell'], $product->category ? $product->category->title : '');
echo CHtml::tag(
    'div',
    ['class' => 'col-lg-1 col-md-1 gridCell'],
    $product->price ? ('&#36;' . $product->price) : 'Not set'
);
echo CHtml::tag('div', ['class' => 'col-lg-3 col-md-3 gridCell'], $product->description);
echo CHtml::tag(
    'div',
    ['class' => 'col-lg-1 col-md-1 gridCell'],
    $product->is_active ? Yii::t('label', 'active') : Yii::t('label', 'disabled')
);
echo CHtml::tag(
    'div',
    ['class' => 'col-lg-1 col-md-1 gridCell'],
    $product->is_banned ? Yii::t('label', 'yes') : Yii::t('label', 'no')
);
echo CHtml::tag(
    'div',
    ['class' => 'col-lg-1 col-md-1 gridCell'],
    CHtml::link(
        Yii::t('label', 'edit'),
        Yii::app()->urlManager->createUrl(
            'products/update',
            array(
                'shop_id' => $product->shop->id,
                'product_id' => $product->id
            )
        ),
        [
            'class' => 'btn btn-default btn-block'
        ]
    )
);

echo CHtml::closeTag('div');