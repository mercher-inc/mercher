@import "../../src/main.less";

<?php

if ($this->template->form->primary_color) {
    echo '@brand-primary: ' . $this->template->form->primary_color . ';';
}

?>