<?php
/* @var $this SiteController */
/* @var $error array */

$this->pageTitle=Yii::app()->name . ' - Error';

Yii::app()->controller->headerTitle = 'Error ' . (int) $code;
?>

<div class="container">
    <?php echo CHtml::encode($message); ?>
</div>