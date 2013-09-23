<h1><?php echo Yii::t('label', 'showcases') ?></h1>

<?php if (!count($this->showcases)) { ?>
    <div class="alert alert-info">
        <?php echo Yii::t('showcase', 'not_found') ?>
        <a class="btn btn-primary" href="<?php echo Yii::app()->urlManager->createUrl('showcases/create') ?>"><?php echo Yii::t('label', 'create') ?></a>
    </div>
<?php } else { ?>
    <table class="table table-hover">
        <thead>
        <tr>
            <th><?php echo Yii::t('label', '#') ?></th>
            <th><?php echo Yii::t('showcase', Showcase::model()->getAttributeLabel('is_active')) ?></th>
            <th><?php echo Yii::t('showcase', Showcase::model()->getAttributeLabel('is_banned')) ?></th>
            <th><?php echo Yii::t('showcase', Showcase::model()->getAttributeLabel('title')) ?></th>
            <th><?php echo Yii::t('showcase', Showcase::model()->getAttributeLabel('description')) ?></th>
            <th><?php echo Yii::t('showcase', Showcase::model()->getAttributeLabel('shop')) ?></th>
            <th>
                <div class="pull-right">
                    <a class="btn btn-success" target="_blank" href="//www.facebook.com/pages/create/"><?php echo Yii::t('label', 'create') ?></a>
                </div>
            </th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($this->showcases as $showcase) {
            $this->render('showcases_widget/item', array('showcase' => $showcase));
        } ?>
        </tbody>
    </table>
<?php } ?>