<?php
/**
 * @var $this ProductsController
 * @var $clientScript CClientScript
 */
$clientScript = Yii::app()->clientScript;
$this->printOg($this->product->ogParams);

$clientScript->registerScript(
    'redirect',
    'location.replace("'
        . 'https://www.facebook.com/'
        . $this->product->shop->fb_id
        . '?'
        . http_build_query([
            'sk'       => 'app_' . Yii::app()->facebook->sdk->getAppId()
        ])
        . '");',
    CClientScript::POS_HEAD
);
?>