<?php
/* @var $this ShopsWidget */
/* @var $shop Shop */
?>

<tr>
    <td>
        <?php echo $shop->id ?>
    </td>
    <td>
        <?php echo $shop->is_active ? Yii::t('label', 'active') : Yii::t('label', 'disabled') ?>
    </td>
    <td>
        <?php echo $shop->is_banned ? Yii::t('label', 'yes') : Yii::t('label', 'no') ?>
    </td>
    <td>
        <a href="<?php echo Yii::app()->urlManager->createUrl(
            'shops/read',
            array('shop_id' => $shop->id)
        ) ?>"><?php echo $shop->title ?></a>
    </td>
    <td>
        <?php echo $shop->description ?>
    </td>
    <td>
        <?php echo $shop->fb_id ?>
    </td>
    <td>
        <div class="pull-right">
            <a class="btn btn-default" href="<?php echo Yii::app()->urlManager->createUrl(
                'shops/update',
                array('shop_id' => $shop->id)
            ) ?>"><?php echo Yii::t('shop', 'edit') ?></a>
            <a class="btn btn-danger" href="<?php echo Yii::app()->urlManager->createUrl(
                'shops/delete',
                array('shop_id' => $shop->id)
            ) ?>"><?php echo Yii::t('shop', 'delete') ?></a>
        </div>
    </td>
</tr>