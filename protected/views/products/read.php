<?php
/* @var $this ProductsController */
?>

<dl>
    <dt><?php echo Yii::t('product', $this->product->getAttributeLabel('title')) ?></dt>
    <dd><?php echo $this->product->title ?></dd>
    <dt><?php echo Yii::t('product', $this->product->getAttributeLabel('description')) ?></dt>
    <dd><?php echo $this->product->description ?></dd>
    <dt><?php echo Yii::t('product', $this->product->getAttributeLabel('category_id')) ?></dt>
    <dd><?php echo $this->product->category ? $this->product->category->title : '' ?></dd>
    <dt><?php echo Yii::t('product', $this->product->getAttributeLabel('amount')) ?></dt>
    <dd><?php echo $this->product->amount ?></dd>
</dl>