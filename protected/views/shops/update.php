<?php
/**
 * @var $this ShopsController
 * @var $model Shop
 * @var $form CActiveForm
 */

Yii::app()->controller->headerTitle = Yii::t('shop', 'edit');

$form = $this->beginWidget(
    'ActiveForm',
    [
        'id'                   => 'shop-form',
        'enableAjaxValidation' => false,
        'htmlOptions'          => [
            'class' => 'main-form',
        ]
    ]
);

$messages = Yii::app()->user->getFlashes('Shop');
if (count($messages)) {
    Yii::app()->clientScript->registerPackage('bootstrap');
}
foreach ($messages as $key => $message) {
    echo '<div class="alert alert-info"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>' . $message . "</div>\n";
}

Yii::app()->clientScript->registerPackage('bootstrap');
Yii::app()->clientScript->registerScript(
    'shop-form-tooltips',
    "$('#shop-form *[data-toggle=\"tooltip\"]').tooltip();"
);
?>

    <legend>Tab settings</legend>

    <div class="row">
        <div class="col-lg-2">
            <div class="row">
                <div class="form-group col-lg-12 <?= $model->hasErrors('image_id') ? ' has-error' : '' ?>">
                    <?php
                    echo $form->label($model, 'image_id', ['class' => 'control-label']);
                    $this->widget(
                        'application.widgets.ImageUploadWidget',
                        [
                            'model'       => $model,
                            'attribute'   => 'image_id',
                            'htmlOptions' => [
                                'style' => 'width: 111px; height: 74px;'
                            ]
                        ]
                    );
                    echo $form->error($model, 'image_id', ['class' => 'help-block']);
                    ?>
                </div>
            </div>
        </div>
        <div class="col-lg-10">
            <div class="row">
                <div class="form-group col-lg-12 <?= $model->hasErrors('title') ? ' has-error' : '' ?>">
                    <?php
                    echo $form->label($model, 'title', ['class' => 'control-label']);
                    echo $form->textField(
                        $model,
                        'title',
                        [
                            'class'       => 'form-control',
                            'data-toggle' => 'tooltip',
                            'title'       => Yii::t('shop', 'help_title')
                        ]
                    );
                    echo $form->error($model, 'title', ['class' => 'help-block']);
                    ?>
                </div>
            </div>
            <div class="row">
                <div class="form-group col-lg-12">
                    <div class="checkbox <?= $model->hasErrors('is_active') ? ' has-error' : '' ?>">
                        <?php
                        echo $form->label(
                            $model,
                            'is_active',
                            [
                                'class'       => 'control-label',
                                'data-toggle' => 'tooltip',
                                'title'       => Yii::t('shop', 'help_is_active')
                            ]
                        );
                        echo $form->checkBox(
                            $model,
                            'is_active',
                            array(
                                'uncheckValue' => 0
                            )
                        );
                        echo $form->error($model, 'is_active', ['class' => 'help-block']);
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <legend>Shop settings</legend>

    <div class="row">
        <div class="form-group col-lg-12">
            <?php
            echo $form->label($model, 'pp_merchant_id', ['class' => 'control-label']);
            echo CHtml::openTag('div', ['class' => 'input-group']);
            echo $form->textField(
                $model,
                'pp_merchant_id',
                [
                    'class'       => 'form-control',
                    'data-toggle' => 'tooltip',
                    'title'       => Yii::t('shop', 'help_pp_merchant_id'),
                    'disabled'    => true,
                ]
            );
            echo CHtml::openTag('div', ['class' => 'input-group-btn']);
            echo CHtml::link(
                'Change',
                $this->createUrl('updatePayPalAccount', ['shop_id' => $model->id]),
                ['class' => 'btn btn-default']
            );
            echo CHtml::closeTag('div');
            echo CHtml::closeTag('div');
            echo $form->error($model, 'pp_merchant_id', ['class' => 'help-block']);
            ?>
        </div>
    </div>

    <div class="row">
        <div class="form-group col-lg-12 <?= $model->hasErrors('tax') ? ' has-error' : '' ?>">
            <?php
            echo $form->label($model, 'tax', ['class' => 'control-label']);
            echo $form->textField(
                $model,
                'tax',
                [
                    'class'       => 'form-control',
                    'data-toggle' => 'tooltip',
                    'title'       => Yii::t('shop', 'help_tax'),
                    'placeholder' => '10'
                ]
            );
            echo $form->error($model, 'tax', ['class' => 'help-block']);
            ?>
        </div>
    </div>

    <div class="row">
        <div class="form-group col-lg-12 <?= $model->hasErrors('ga_id') ? ' has-error' : '' ?>">
            <?php
            echo $form->label($model, 'ga_id', ['class' => 'control-label']);
            echo $form->textField(
                $model,
                'ga_id',
                [
                    'class'       => 'form-control',
                    'data-toggle' => 'tooltip',
                    'title'       => Yii::t('shop', 'help_ga_id'),
                    'placeholder' => 'UA-12345678-12'
                ]
            );
            echo $form->error($model, 'ga_id', ['class' => 'help-block']);
            ?>
        </div>
    </div>

    <div class="row">
        <div class="form-group col-lg-12 <?= $model->hasErrors('description') ? ' has-error' : '' ?>">
            <?php
            echo $form->label($model, 'description', ['class' => 'control-label']);
            echo $form->textArea(
                $model,
                'description',
                [
                    'class'       => 'form-control',
                    'data-toggle' => 'tooltip',
                    'title'       => Yii::t('shop', 'help_description')
                ]
            );
            echo $form->error($model, 'description', ['class' => 'help-block']);
            ?>
        </div>
    </div>

    <div class="row">
        <div class="form-group actions col-lg-12">
            <?php
            echo CHtml::submitButton(
                Yii::t('shop', 'save'),
                array(
                    'class' => 'btn btn-primary'
                )
            );
            ?>
        </div>
    </div>

<?php
$this->endWidget();