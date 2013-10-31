<?php Yii::app()->controller->headerTitle = Yii::t('label', 'categories') ?>

<?php
Yii::app()->controller->headerButtons = [
    [
        'title'       => Yii::t('category', 'create'),
        'url'         => Yii::app()->urlManager->createUrl('categories/create', array('shop_id'=>$this->shop->id))
    ],
];
?>

<?php if (!count($this->categories)) { ?>
    <div class="alert alert-info">
        <?php echo Yii::t('category', 'no_items_found') ?>
        <a class="btn btn-primary" href="<?php echo Yii::app()->urlManager->createUrl('categories/create', array('shop_id'=>$this->shop->id)) ?>"><?php echo Yii::t('category', 'create') ?></a>
    </div>
<?php } else { ?>
    <div class="gridView">
        <div class="header hidden-sm hidden-xs">
            <div class="row">
                <div class="col-lg-1 col-md-1"><?php echo Yii::t('label', '#') ?></div>
                <div class="col-lg-3 col-md-3"><?php echo Yii::t('category', Category::model()->getAttributeLabel('title')) ?></div>
                <div class="col-lg-5 col-md-5"><?php echo Yii::t('category', Category::model()->getAttributeLabel('description')) ?></div>
                <div class="col-lg-1 col-md-1"><?php echo Yii::t('category', Category::model()->getAttributeLabel('is_active')) ?></div>
                <div class="col-lg-1 col-md-1"><?php echo Yii::t('category', Category::model()->getAttributeLabel('is_banned')) ?></div>
                <div class="col-lg-1 col-md-1"></div>
            </div>
        </div>
        <?php foreach ($this->categories as $category) {
            $this->render('categories_widget/item', array('category' => $category));
        } ?>
    </div>
<?php } ?>