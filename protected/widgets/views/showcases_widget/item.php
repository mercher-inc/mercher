<?php
/* @var $this ShowcasesWidget */
/* @var $showcase Showcase */
?>

<tr>
    <td>
        <?php echo $showcase->id ? $showcase->id : Yii::t('label', 'new') ?>
    </td>
    <td>
        <?php echo $showcase->is_active ? Yii::t('label', 'active') : Yii::t('label', 'disabled') ?>
    </td>
    <td>
        <?php echo $showcase->is_banned ? Yii::t('label', 'yes') : Yii::t('label', 'no') ?>
    </td>
    <td>
        <img src="//graph.facebook.com/<?php echo $showcase->fb_id ?>/picture" class="img-circle"
             style="margin: 0 10px 10px 0; float: left; height: 50px; width: 50px;">

        <?php if (!$showcase->isNewRecord) { ?>
            <a href="<?php echo Yii::app()->urlManager->createUrl(
                'showcases/get',
                array('showcase_id' => $showcase->id)
            ) ?>"><?php echo $showcase->title ?></a>
        <?php } else { ?>
            <?php echo $showcase->title ?>
        <?php } ?>
    </td>
    <td>
        <?php echo $showcase->description ?>
    </td>
    <td>
        <?php if (!$showcase->isNewRecord and $showcase->shop) { ?>
            <a href="<?php echo Yii::app()->urlManager->createUrl(
                'shops/get',
                array('shop_id' => $showcase->shop->id)
            ) ?>"><?php echo $showcase->shop->title ?></a>
        <?php } else { ?>
            <?php echo Yii::t('label', 'not_set') ?>
        <?php } ?>
    </td>
    <td>
        <div class="pull-right">
            <?php if ($showcase->isNewRecord) { ?>
                <a class="btn btn-default" href="<?php echo Yii::app()->urlManager->createUrl(
                    'showcases/add',
                    array('page_id' => $showcase->fb_id)
                ) ?>"><?php echo Yii::t('label', 'add') ?></a>
            <?php } else { ?>
                <a class="btn btn-default" href="<?php echo Yii::app()->urlManager->createUrl(
                    'showcases/edit',
                    array('showcase_id' => $showcase->id)
                ) ?>"><?php echo Yii::t('label', 'edit') ?></a>
            <?php } ?>
        </div>
    </td>
</tr>