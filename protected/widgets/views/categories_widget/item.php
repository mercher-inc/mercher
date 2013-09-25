<?php
/* @var $this CategoriesWidget */
/* @var $category Category */
?>

<tr>
    <td>
        <?php echo $category->id ?>
    </td>
    <td>
        <?php echo $category->is_active ? Yii::t('label', 'active') : Yii::t('label', 'disabled') ?>
    </td>
    <td>
        <?php echo $category->is_banned ? Yii::t('label', 'yes') : Yii::t('label', 'no') ?>
    </td>
    <td>
        <a href="<?php echo Yii::app()->urlManager->createUrl(
            'categories/read',
            array(
                'shop_id'     => $this->shop->id,
                'category_id' => $category->id
            )
        ) ?>"><?php echo $category->title ?></a>
    </td>
    <td>
        <?php echo $category->description ?>
    </td>
    <td>
        <div class="pull-right">
            <a class="btn btn-default" href="<?php echo Yii::app()->urlManager->createUrl(
                'categories/update',
                array(
                    'shop_id'     => $this->shop->id,
                    'category_id' => $category->id
                )
            ) ?>"><?php echo Yii::t('category', 'edit') ?></a>
            <!--
            <a class="btn btn-danger" href="<?php echo Yii::app()->urlManager->createUrl(
                'categories/delete',
                array(
                    'shop_id'     => $this->shop->id,
                    'category_id' => $category->id
                )
            ) ?>"><?php echo Yii::t('category', 'delete') ?></a>
            -->
        </div>
    </td>
</tr>