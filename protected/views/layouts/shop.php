<?php /* @var $this Controller */ ?>
<?php $this->beginContent('//layouts/main'); ?>
    <div class="container">
        <div id="content">
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
                                        'label' => Yii::t('shop', 'summary'),
                                        'url'   => array('shops/read', 'shop_id' => $this->shop->id)
                                    ),
                                    array(
                                        'label' => Yii::t('shop', 'edit'),
                                        'url'   => array('shops/update', 'shop_id' => $this->shop->id)
                                    ),
                                    array(
                                        'label' => Yii::t('label', 'categories'),
                                        'url'   => array('categories/index', 'shop_id' => $this->shop->id)
                                    ),
                                    array(
                                        'label' => Yii::t('label', 'products'),
                                        'url'   => array('products/index', 'shop_id' => $this->shop->id)
                                    ),
                                    array(
                                        'label' => Yii::t('label', 'design'),
                                        'url'   => array('design/index', 'shop_id' => $this->shop->id)
                                    ),
                                    /*
                                    array(
                                        'label' => Yii::t('label', 'orders'),
                                        'url'   => array('orders/index', 'shop_id' => $this->shop->id)
                                    )
                                    */
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
                        <?php
                        $messages = Yii::app()->user->getFlashes();
                        if (count($messages)) {
                            Yii::app()->clientScript->registerPackage('bootstrap');
                        }
                        foreach ($messages as $key => $message) {
                            echo '<div class="alert alert-' . $key . ' alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>' . $message . "</div>\n";
                        }
                        ?>
                        <?php echo $content; ?>
                    </div>
                </div>
            </div>
        </div>
        <!-- content -->
    </div>
<?php $this->endContent(); ?>