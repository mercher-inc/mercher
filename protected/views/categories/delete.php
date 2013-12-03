<?php
/**
 * @var $this CategoriesController
 * @var $model Category
 * @var $form ActiveForm
 */

Yii::app()->controller->headerTitle = Yii::t('category', 'delete');

$form = $this->beginWidget(
    'ActiveForm',
    [
        'id'                   => 'category-delete-form',
        'enableAjaxValidation' => false,
        'htmlOptions'          => [
            'class'   => 'main-form'
        ]
    ]
);
?>

<div class="alert alert-danger">
    <p>
        Do you really want to delete category "<?php echo $model->title ?>"?
    </p>
    <p>
        <input type="hidden" name="_method" value="DELETE">
        <input type="submit" class="btn btn-danger" value="Yes">
        <?= CHtml::link('No', $this->createUrl('index', ['shop_id'=>$this->shop->id]), ['class'=>'btn btn-default']) ?>
    </p>
</div>

<?php
$this->endWidget();
?>

