<?php
/* @var $this SiteController */
/* @var $model ContactForm */
/* @var $form CActiveForm */

$this->pageTitle = Yii::app()->name . ' - ' . Yii::t('label', 'contact');

Yii::app()->controller->headerTitle = Yii::t('label', 'contact');

$this->breadcrumbs = array(
    'Contact',
);
?>

<?php if (Yii::app()->user->hasFlash('contact')): ?>

    <div class="main-form">
        <div class="alert alert-info">
            <?php echo Yii::app()->user->getFlash('contact'); ?>
        </div>
    </div>

<?php else: ?>

    <div class="form">

        <?php $form = $this->beginWidget(
            'ActiveForm',
            array(
                'id'                     => 'contact-form',
                'enableClientValidation' => true,
                'clientOptions'          => array(
                    'validateOnSubmit' => true,
                    'errorCssClass' => 'has-error'
                ),
                'htmlOptions'            => [
                    'class' => 'main-form',
                ]
            )
        ); ?>

        <legend>
            If you have any questions, please fill out the following form to contact us
        </legend>

        <div class="row">
            <div class="form-group col-lg-12 <?= $model->hasErrors('name') ? ' has-error' : '' ?>">
                <?php
                echo $form->labelEx($model, 'name', ['class' => 'control-label']);
                echo $form->textField($model, 'name', ['class' => 'form-control']);
                echo $form->error($model, 'name', ['class' => 'help-block']);
                ?>
            </div>
        </div>

        <div class="row">
            <div class="form-group col-lg-12 <?= $model->hasErrors('email') ? ' has-error' : '' ?>">
                <?php echo $form->labelEx($model, 'email', ['class' => 'control-label']); ?>
                <?php echo $form->textField($model, 'email', ['class' => 'form-control']); ?>
                <?php echo $form->error($model, 'email', ['class' => 'help-block']); ?>
            </div>
        </div>

        <div class="row">
            <div class="form-group col-lg-12 <?= $model->hasErrors('subject') ? ' has-error' : '' ?>">
                <?php echo $form->labelEx($model, 'subject', ['class' => 'control-label']); ?>
                <?php echo $form->textField($model, 'subject', ['class' => 'form-control']); ?>
                <?php echo $form->error($model, 'subject', ['class' => 'help-block']); ?>
            </div>
        </div>

        <div class="row">
            <div class="form-group col-lg-12 <?= $model->hasErrors('body') ? ' has-error' : '' ?>">
                <?php echo $form->labelEx($model, 'body', ['class' => 'control-label']); ?>
                <?php echo $form->textArea($model, 'body', ['class' => 'form-control']); ?>
                <?php echo $form->error($model, 'body', ['class' => 'help-block']); ?>
            </div>
        </div>

        <?php if (CCaptcha::checkRequirements()): ?>
            <div class="row">
                <div class="col-lg-4">
                    <?php $this->widget('CCaptcha'); ?>
                    <div class="help-block">
                        Please enter the letters as they are shown in the image above.
                        Letters are not case-sensitive.
                    </div>
                </div>
                <div class="form-group col-lg-8 <?= $model->hasErrors('verifyCode') ? ' has-error' : '' ?>">
                    <?php echo $form->labelEx($model, 'verifyCode', ['class' => 'control-label']); ?>
                    <?php echo $form->textField($model, 'verifyCode', ['class' => 'form-control']); ?>
                    <?php echo $form->error($model, 'verifyCode', ['class' => 'help-block']); ?>
                </div>
            </div>
        <?php endif; ?>

        <div class="row">
            <div class="form-group actions col-lg-12">
                <?php echo CHtml::submitButton('Submit', ['class'=>'btn btn-primary']); ?>
            </div>
        </div>

        <?php $this->endWidget(); ?>

    </div><!-- form -->

<?php endif; ?>