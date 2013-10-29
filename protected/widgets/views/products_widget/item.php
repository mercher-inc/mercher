<?php
/* @var $this ProductsWidget */
/* @var $product Product */
?>

<tr>
    <td>
        <?php echo $product->id ?>
    </td>
    <td>
        <?php echo $product->is_active ? Yii::t('label', 'active') : Yii::t('label', 'disabled') ?>
    </td>
    <td>
        <?php echo $product->is_banned ? Yii::t('label', 'yes') : Yii::t('label', 'no') ?>
    </td>
    <td>
        <a href="<?php echo Yii::app()->urlManager->createUrl(
            'products/read',
            array(
                'shop_id'    => $this->shop->id,
                'product_id' => $product->id
            )
        ) ?>"><?php echo $product->title ?></a>
    </td>
    <td>
        <?php if ($product->category) { ?>
            <a href="<?php echo Yii::app()->urlManager->createUrl(
                'categories/read',
                array(
                    'shop_id'     => $this->shop->id,
                    'category_id' => $product->category->id
                )
            ) ?>"><?php echo $product->category->title ?></a>
        <?php } ?>
    </td>
    <td>
        <?php echo $product->amount?('&#36;'.$product->amount):'Not set' ?>
    </td>
    <td>
        <?php echo $product->description ?>
    </td>
    <td>
        <a href="//www.facebook.com/<?php echo $product->fb_id ?>" target="_blank"><?php echo $product->fb_id ?></a>
    </td>
    <td>
        <div class="pull-right">
            <a class="btn btn-default" href="<?php echo Yii::app()->urlManager->createUrl(
                'products/update',
                array(
                    'shop_id'    => $this->shop->id,
                    'product_id' => $product->id
                )
            ) ?>"><?php echo Yii::t('product', 'edit') ?></a>
            <!--
            <a class="btn btn-danger" href="<?php echo Yii::app()->urlManager->createUrl(
                'products/delete',
                array(
                    'shop_id'    => $this->shop->id,
                    'product_id' => $product->id
                )
            ) ?>"><?php echo Yii::t('product', 'delete') ?></a>
            -->
        </div>
    </td>
</tr>