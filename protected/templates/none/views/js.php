var config = <?php
echo CJSON::encode(
    array(
        'shop'  => array(
            'id'    => $this->template->shop->id,
            'page'  => $this->template->shop->fb_id,
            'title' => $this->template->shop->title,
        ),
        'title' => $this->template->form->title,
    )
);
?>;