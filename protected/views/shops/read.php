<?php
/* @var $this ShopsController */
/* @var $shop Shop */
?>

<dl>
    <dt><?php echo Yii::t('shop', $this->shop->getAttributeLabel('title')) ?></dt>
    <dd><?php echo $this->shop->title ?></dd>
    <dt><?php echo Yii::t('shop', $this->shop->getAttributeLabel('description')) ?></dt>
    <dd><?php echo $this->shop->description ?></dd>
    <dt><?php echo Yii::t('shop', $this->shop->getAttributeLabel('fb_id')) ?></dt>
    <dd><?php echo $this->shop->fb_id ?></dd>
</dl>