<?php
/**
 * @var $this ManagersController
 * @var $model Manager
 * @var $form ActiveForm
 */

Yii::app()->controller->headerTitle = Yii::t('manager', 'delete');

$form = $this->beginWidget(
    'ActiveForm',
    [
        'id'                   => 'manager-delete-form',
        'enableAjaxValidation' => false,
        'htmlOptions'          => [
            'class'   => 'main-form'
        ]
    ]
);
?>

<div class="alert alert-danger">
    <p>
        Do you really want to remove manager "<?php echo $model->user->name ?>"?
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

