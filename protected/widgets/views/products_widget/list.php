<?php Yii::app()->controller->headerTitle = Yii::t('label', 'products') ?>

<?php
Yii::app()->controller->headerButtons = [
    [
        'title'       => Yii::t('product', 'create'),
        'url'         => Yii::app()->urlManager->createUrl('products/create', array('shop_id' => $this->shop->id))
    ],
];
?>

<?php if (!count($this->products)) { ?>
    <div class="alert alert-info">
        <?php echo Yii::t('product', 'no_items_found') ?>
        <a class="btn btn-primary" href="<?php echo Yii::app()->urlManager->createUrl(
            'products/create',
            array('shop_id' => $this->shop->id)
        ) ?>"><?php echo Yii::t('product', 'create') ?></a>
    </div>
<?php } else { ?>
    <div class="gridView">
        <div class="header hidden-sm hidden-xs">
            <div class="row">
                <div class="col-lg-1 col-md-1"><?php echo Yii::t('label', '#') ?></div>
                <div class="col-lg-1 col-md-1"><?php echo Yii::t('product', Product::model()->getAttributeLabel('image_id')) ?></div>
                <div class="col-lg-2 col-md-2"><?php echo Yii::t('product', Product::model()->getAttributeLabel('title')) ?></div>
                <div class="col-lg-1 col-md-1"><?php echo Yii::t('product', Product::model()->getAttributeLabel('category')) ?></div>
                <div class="col-lg-1 col-md-1"><?php echo Yii::t('product', Product::model()->getAttributeLabel('amount')) ?></div>
                <div class="col-lg-3 col-md-3"><?php echo Yii::t('product', Product::model()->getAttributeLabel('description')) ?></div>
                <div class="col-lg-1 col-md-1"><?php echo Yii::t('product', Product::model()->getAttributeLabel('is_active')) ?></div>
                <div class="col-lg-1 col-md-1"><?php echo Yii::t('product', Product::model()->getAttributeLabel('is_banned')) ?></div>
                <div class="col-lg-1 col-md-1"></div>
            </div>
        </div>
        <?php foreach ($this->products as $product) {
            $this->render('products_widget/item', array('product' => $product));
        } ?>
    </div>
<?php } ?>