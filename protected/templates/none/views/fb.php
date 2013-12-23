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
    FB._namespace = '<?= (APPLICATION_ENV == 'production')?'mercher':'mercherdev'?>';
    return FB;
});