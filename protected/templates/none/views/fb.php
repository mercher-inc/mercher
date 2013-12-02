<?php
/**
 * @var $this \templates\none\Template
 */
?>

define(['facebook'], function () {
    FB.init(<?= CJSON::encode([
        'appId' =>  Yii::app()->facebook->sdk->getAppId()
    ]) ?>);
    return FB;
});