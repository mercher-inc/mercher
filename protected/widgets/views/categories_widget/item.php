<?php
/* @var $this CategoriesWidget */
/* @var $category Category */

echo CHtml::openTag('div', ['class'=>'row']);

echo CHtml::tag('div', ['class'=>'col-lg-1 col-md-1'], $category->id);
echo CHtml::tag('div', ['class' => 'col-lg-3 col-md-3'], $category->title);
echo CHtml::tag('div', ['class' => 'col-lg-5 col-md-5'], $category->description);
echo CHtml::tag('div', ['class' => 'col-lg-1 col-md-1'], $category->is_active ? Yii::t('label', 'active') : Yii::t('label', 'disabled'));
echo CHtml::tag('div', ['class' => 'col-lg-1 col-md-1'], $category->is_banned ? Yii::t('label', 'yes') : Yii::t('label', 'no'));
echo CHtml::tag(
    'div',
    ['class' => 'col-lg-1 col-md-1'],
    CHtml::link(
        Yii::t('label', 'edit'),
        Yii::app()->urlManager->createUrl(
            'categories/update',
            array(
                'shop_id'    => $category->shop->id,
                'category_id' => $category->id
            )
        ),
        [
            'class'=>'btn btn-default btn-block'
        ]
    )
);

echo CHtml::closeTag('div');