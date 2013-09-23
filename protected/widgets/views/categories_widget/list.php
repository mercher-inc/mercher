<h1><?php echo Yii::t('label', 'categories') ?></h1>

<?php if (!count($this->categories)) { ?>
    <div class="alert alert-info">
        <?php echo Yii::t('category', 'no_items_found') ?>
        <a class="btn btn-primary" href="<?php echo Yii::app()->urlManager->createUrl('categories/create', array('shop_id'=>$this->shop->id)) ?>"><?php echo Yii::t('label', 'create') ?></a>
    </div>
<?php } else { ?>
    <table class="table table-hover">
        <thead>
        <tr>
            <th><?php echo Yii::t('label', '#') ?></th>
            <th><?php echo Yii::t('category', Category::model()->getAttributeLabel('is_active')) ?></th>
            <th><?php echo Yii::t('category', Category::model()->getAttributeLabel('is_banned')) ?></th>
            <th><?php echo Yii::t('category', Category::model()->getAttributeLabel('title')) ?></th>
            <th><?php echo Yii::t('category', Category::model()->getAttributeLabel('description')) ?></th>
            <th>
                <div class="pull-right">
                    <a class="btn btn-success" href="<?php echo Yii::app()->urlManager->createUrl('categories/create', array('shop_id'=>$this->shop->id)) ?>"><?php echo Yii::t('label', 'create') ?></a>
                </div>
            </th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($this->categories as $category) {
            $this->render('categories_widget/item', array('category' => $category));
        } ?>
        </tbody>
    </table>
<?php } ?>