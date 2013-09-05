<?php
/* @var $this SiteController */

$this->pageTitle = Yii::app()->name;
?>

<h1>Welcome to <?php echo CHtml::encode(Yii::app()->name); ?></h1>

<a class="btn btn-primary btn-lg" href="<?php echo Yii::app()->facebook->getLoginUrl() ?>" target="_top">Login</a>

<button class="btn btn-primary btn-lg" onclick="FB.ui({method:'pagetab'});" >Add shop to your page</button>