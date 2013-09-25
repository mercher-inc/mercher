<?php
/* @var $this Controller */
Yii::app()->clientScript->registerMetaTag('text/html; charset=UTF-8', null, 'Content-Type');
Yii::app()->clientScript->registerMetaTag(
    'width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no',
    'viewport'
);
Yii::app()->clientScript->registerMetaTag('en', 'language');
?>
<!DOCTYPE HTML>
<html lang="en">
<head>
</head>

<body>
<div id="fb-root"></div>
<div id="page">
    <?php echo $content; ?>
</div>
<!-- page -->

</body>
</html>
