<?php
/**
 * @var $this \templates\none\Template
 */
?>

define(['facebook'], function () {
    FB.init(<?=
        CJSON::encode(
            [
                'appId'  => Yii::app()->facebook->sdk->getAppId(),
                'logging' => false,
                'status'  => true,
                'cookie'  => true,
                'xfbml'   => true,
            ]
        )
    ?>);
    FB._namespace = '<?= Yii::app()->facebook->namespace ?>';
    return FB;
});