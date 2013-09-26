@import "../../src/main.less";

<?php

if ($this->template->form->bg_color) {
    echo '@body-bg: ' . $this->template->form->bg_color . ';';
}

?>