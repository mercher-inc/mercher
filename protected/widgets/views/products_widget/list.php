<?php Yii::app()->controller->headerTitle = Yii::t('label', 'products') ?>

<?php
Yii::app()->controller->headerTable = [
    [
        'title'       => Yii::t('label', '#'),
        'htmlOptions' => [
            'style' => 'width: 5%;'
        ]
    ],
    [
        'title'       => Yii::t('product', Product::model()->getAttributeLabel('title')),
        'htmlOptions' => [
            'style' => 'width: 10%;'
        ]
    ],
    [
        'title'       => Yii::t('product', Product::model()->getAttributeLabel('category')),
        'htmlOptions' => [
            'style' => 'width: 10%;'
        ]
    ],
    [
        'title'       => Yii::t('product', Product::model()->getAttributeLabel('amount')),
        'htmlOptions' => [
            'style' => 'width: 10%;'
        ]
    ],
    [
        'title'       => Yii::t('product', Product::model()->getAttributeLabel('description')),
        'htmlOptions' => [
            'style' => 'width: 20%;'
        ]
    ],
    [
        'title'       => Yii::t('product', Product::model()->getAttributeLabel('is_active')),
        'htmlOptions' => [
            'style' => 'width: 5%;'
        ]
    ],
    [
        'title'       => Yii::t('product', Product::model()->getAttributeLabel('is_banned')),
        'htmlOptions' => [
            'style' => 'width: 5%;'
        ]
    ],
    [
        'title'       => '',
        'htmlOptions' => [
            'style' => 'width: 5%;'
        ]
    ]
];

Yii::app()->controller->headerButtons = [
    [
        'title'       => Yii::t('product', 'create'),
        'url'         => Yii::app()->urlManager->createUrl('products/create', array('shop_id' => $this->shop->id))
    ],
];
?>

<?php if (!count($this->products)) { ?>
    <div class="alert alert-info">
        <?php echo Yii::t('product', 'no_items_found') ?>
        <a class="btn btn-primary" href="<?php echo Yii::app()->urlManager->createUrl(
            'products/create',
            array('shop_id' => $this->shop->id)
        ) ?>"><?php echo Yii::t('product', 'create') ?></a>
    </div>
<?php } else { ?>
    <table class="table table-hover">
        <tbody>
        <?php foreach ($this->products as $product) {
            $this->render('products_widget/item', array('product' => $product));
        } ?>
        </tbody>
    </table>
<?php } ?>