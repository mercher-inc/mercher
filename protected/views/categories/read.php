<?php
/* @var $this CategoriesController */
?>

<dl>
    <dt><?php echo Yii::t('category', $this->category->getAttributeLabel('title')) ?></dt>
    <dd><?php echo $this->category->title ?></dd>
    <dt><?php echo Yii::t('category', $this->category->getAttributeLabel('description')) ?></dt>
    <dd><?php echo $this->category->description ?></dd>
</dl>