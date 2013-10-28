<h1><?php echo Yii::t('label', 'shops') ?></h1>

<?php if (!count($this->shops)) { ?>
    <div class="alert alert-info">
        <?php echo Yii::t('shop', 'no_items_found') ?>
        <a class="btn btn-primary"
           href="<?php echo Yii::app()->urlManager->createUrl('shops/create') ?>"><?php echo Yii::t(
                'shop',
                'create'
            ) ?></a>
    </div>
<?php } else { ?>
    <table class="table table-hover">
        <thead>
        <tr>
            <th><?php echo Yii::t('label', '#') ?></th>
            <th><?php echo Yii::t('shop', Shop::model()->getAttributeLabel('is_active')) ?></th>
            <th><?php echo Yii::t('shop', Shop::model()->getAttributeLabel('is_banned')) ?></th>
            <th><?php echo Yii::t('shop', Shop::model()->getAttributeLabel('title')) ?></th>
            <th><?php echo Yii::t('shop', Shop::model()->getAttributeLabel('description')) ?></th>
            <th><?php echo Yii::t('shop', Shop::model()->getAttributeLabel('pp_merchant_id')) ?></th>
            <th><?php echo Yii::t('shop', Shop::model()->getAttributeLabel('page')) ?></th>
            <th>
                <div class="pull-right">
                    <a class="btn btn-success"
                       href="<?php echo Yii::app()->urlManager->createUrl('shops/create') ?>"><?php echo Yii::t(
                            'shop',
                            'create'
                        ) ?></a>
                </div>
            </th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($this->shops as $shop) {
            $this->render('shops_widget/item', array('shop' => $shop));
        } ?>
        </tbody>
    </table>
<?php } ?>