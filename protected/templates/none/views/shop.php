<?php
/**
 * @var $this \templates\none\Template
 */
?>

define("shop", ['models/shop'], function (Shop) {
var shop = new Shop(<?=
CJSON::encode(
    [
        'id'             => $this->template->shop->id,
        'page'           => $this->template->shop->fb_id,
        'title'          => $this->template->shop->title,
        'pp_merchant_id' => $this->template->shop->pp_merchant_id,
        'tax'            => (float)$this->template->shop->tax
    ]
) ?>);
return shop;
});