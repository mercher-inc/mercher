<?php
/* @var $this SiteController */
/* @var $error array */

$this->pageTitle = Yii::app()->name . ' - Error';

Yii::app()->controller->headerTitle = 'Error ' . (int)$code;
?>

<div class="container">
    <div class="alert alert-danger" style="margin: 80px 0;">
        <strong>Error <?php echo CHtml::encode($code); ?></strong>
        <?php echo CHtml::encode($message); ?>
    </div>
</div>