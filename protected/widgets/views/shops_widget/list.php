<h1><?php echo Yii::t('label', 'shops') ?></h1>

<?php if (!count($this->shops)) { ?>
    <p>Not found</p>
<?php } else { ?>
    <table class="table table-hover">
        <thead>
            <tr>
                <th><?php echo Yii::t('label', 'state') ?></th>
                <th><?php echo Yii::t('label', 'title') ?></th>
                <th><?php echo Yii::t('label', 'description') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($this->shops as $shop) {
                $this->render('shops_widget/item', array('shop' => $shop));
            } ?>
        </tbody>
    </table>
<?php } ?>