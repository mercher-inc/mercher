<?php /* @var $this Controller */ ?>
<?php $this->beginContent('//layouts/main'); ?>
    <div class="page-header">
        <h1><?php echo $this->shop->title ?></h1>
    </div>
    <div class="row">
        <div class="col-lg-2 col-md-3 col-sm-4">
            <div id="sidebar">
                <?php
                $this->widget(
                    'zii.widgets.CMenu',
                    array(
                        'items'       => array(
                            array(
                                'label' => 'Shop settings',
                                'url'   => array('shops/get', 'shop_id' => $this->shop->id)
                            ),
                            array(
                                'label' => 'Categories',
                                'url'   => array('categories/index', 'shop_id' => $this->shop->id)
                            ),
                            array(
                                'label' => 'Products',
                                'url'   => array('products/index', 'shop_id' => $this->shop->id)
                            ),
                            array(
                                'label' => 'Orders',
                                'url'   => array('orders/index', 'shop_id' => $this->shop->id)
                            )
                        ),
                        'htmlOptions' => array('class' => 'nav nav-pills nav-stacked'),
                    )
                );
                ?>
            </div>
            <!-- sidebar -->
        </div>
        <div class="col-lg-10 col-md-9 col-sm-8">
            <div id="content">
                <?php echo $content; ?>
            </div>
            <!-- content -->
        </div>
    </div>
<?php $this->endContent(); ?>