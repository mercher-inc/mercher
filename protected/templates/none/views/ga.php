<?php
/**
 * @var $this \templates\none\Template
 */
?>

define(['google-analytics'], function (ga) {
    <? if ($this->template->shop->ga_id): ?>
        ga('create', '<?= $this->template->shop->ga_id ?>', 'auto');
    <? endif ?>
    return ga;
});