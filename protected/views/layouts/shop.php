<?php
/**
 * @var $this Controller
 */

$this->menu = array(
    array(
        'label' => Yii::t('label', 'products'),
        'url'   => array('products/index', 'shop_id' => $this->shop->id)
    ),
    array(
        'label' => Yii::t('label', 'categories'),
        'url'   => array('categories/index', 'shop_id' => $this->shop->id)
    ),
    array(
        'label' => Yii::t('label', 'design'),
        'url'   => array('design/index', 'shop_id' => $this->shop->id)
    ),
    array(
        'label' => Yii::t('shop', 'edit'),
        'url'   => array('shops/update', 'shop_id' => $this->shop->id)
    ),
);

$this->beginContent('//layouts/default');

$messages = Yii::app()->user->getFlashes();
if (count($messages)) {
    Yii::app()->clientScript->registerPackage('bootstrap');
}
foreach ($messages as $key => $message) {
    echo '<div class="alert alert-' . $key . ' alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>' . $message . "</div>\n";
}
echo $content;
$this->endContent();