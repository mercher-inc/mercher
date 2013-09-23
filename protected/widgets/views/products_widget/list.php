<h1><?php echo Yii::t('label', 'products') ?></h1>

<?php if (!count($this->products)) { ?>
    <div class="alert alert-info">
        <?php echo Yii::t('product', 'no_items_found') ?>
        <a class="btn btn-primary" href="<?php echo Yii::app()->urlManager->createUrl('products/create', array('shop_id'=>$this->shop->id)) ?>"><?php echo Yii::t('label', 'create') ?></a>
    </div>
<?php } else { ?>
    <table class="table table-hover">
        <thead>
        <tr>
            <th><?php echo Yii::t('label', '#') ?></th>
            <th><?php echo Yii::t('product', Product::model()->getAttributeLabel('is_active')) ?></th>
            <th><?php echo Yii::t('product', Product::model()->getAttributeLabel('is_banned')) ?></th>
            <th><?php echo Yii::t('product', Product::model()->getAttributeLabel('title')) ?></th>
            <th><?php echo Yii::t('product', Product::model()->getAttributeLabel('category')) ?></th>
            <th><?php echo Yii::t('product', Product::model()->getAttributeLabel('price')) ?></th>
            <th><?php echo Yii::t('product', Product::model()->getAttributeLabel('description')) ?></th>
            <th>
                <div class="pull-right">
                    <a class="btn btn-success" href="<?php echo Yii::app()->urlManager->createUrl('products/create', array('shop_id'=>$this->shop->id)) ?>"><?php echo Yii::t('label', 'create') ?></a>
                </div>
            </th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($this->products as $product) {
            $this->render('products_widget/item', array('product' => $product));
        } ?>
        </tbody>
    </table>
<?php } ?>