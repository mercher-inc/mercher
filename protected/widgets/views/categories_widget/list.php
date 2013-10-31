<?php Yii::app()->controller->headerTitle = Yii::t('label', 'categories') ?>

<?php
Yii::app()->controller->headerTable = [
    [
        'title' =>  Yii::t('label', '#'),
        'htmlOptions'=>[
            'style' =>  'width: 5%;'
        ]
    ],
    [
        'title' =>  Yii::t('category', Category::model()->getAttributeLabel('title')),
        'htmlOptions'=>[
            'style' =>  'width: 10%;'
        ]
    ],
    [
        'title' =>  Yii::t('category', Category::model()->getAttributeLabel('description')),
        'htmlOptions'=>[
            'style' =>  'width: 20%;'
        ]
    ],
    [
        'title' =>  Yii::t('category', Category::model()->getAttributeLabel('is_active')),
        'htmlOptions'=>[
            'style' =>  'width: 5%;'
        ]
    ],
    [
        'title' =>  Yii::t('category', Category::model()->getAttributeLabel('is_banned')),
        'htmlOptions'=>[
            'style' =>  'width: 5%;'
        ]
    ],
    [
        'title' =>  '',
        'htmlOptions'=>[
            'style' =>  'width: 5%;'
        ]
    ]
];

Yii::app()->controller->headerButtons = [
    [
        'title'       => Yii::t('category', 'create'),
        'url'         => Yii::app()->urlManager->createUrl('categories/create', array('shop_id'=>$this->shop->id))
    ],
];
?>

<?php if (!count($this->categories)) { ?>
    <div class="alert alert-info">
        <?php echo Yii::t('category', 'no_items_found') ?>
        <a class="btn btn-primary" href="<?php echo Yii::app()->urlManager->createUrl('categories/create', array('shop_id'=>$this->shop->id)) ?>"><?php echo Yii::t('category', 'create') ?></a>
    </div>
<?php } else { ?>
    <table class="table table-hover">
        <tbody>
        <?php foreach ($this->categories as $category) {
            $this->render('categories_widget/item', array('category' => $category));
        } ?>
        </tbody>
    </table>
<?php } ?>