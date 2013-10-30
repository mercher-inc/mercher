<footer>
    <?php $this->widget(
        'zii.widgets.CMenu',
        array(
            'items'       => array(
                array('label' => 'About', 'url' => array('index/page', 'view' => 'about')),
                array('label' => 'Contact', 'url' => array('index/contact')),
                array('label' => 'Support', 'url' => array('support/index')),
            ),
            'htmlOptions' => array(
                'class' => 'nav nav-pills nav-justified'
            )
        )
    ); ?>
    &copy;<?php echo date('Y'); ?> Mercher. All Rights Reserved.
</footer>
<!-- footer -->