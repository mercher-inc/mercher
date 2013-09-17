<?php
/* @var $this ShopsWidget */
/* @var $shop Shop */
?>

<tr>
    <td>
        <?php echo $shop->is_active?Yii::t('label', 'active'):Yii::t('label', 'disabled') ?>
        <?php echo $shop->is_banned?Yii::t('label', 'banned'):'' ?>
    </td>
    <td>
        <?php echo $shop->title ?>
    </td>
    <td>
        <?php echo $shop->description ?>
    </td>
</tr>