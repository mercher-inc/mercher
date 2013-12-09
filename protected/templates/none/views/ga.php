<?php
/**
 * @var $this \templates\none\Template
 */
?>

define(['google-analytics'], function (ga) {
    <?php if ($this->template->shop->ga_id): ?>
        ga('create', '<?= $this->template->shop->ga_id ?>', 'auto');
    <?php endif ?>
    return ga;
});