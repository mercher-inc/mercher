<?php
/* @var $srcPath string */
?>

var appConfig = <?php
echo CJSON::encode(
    array(
        'title'          => $this->template->form->title,
        'perPageCount' => (int) $this->template->form->per_page_count
    )
);
?>;