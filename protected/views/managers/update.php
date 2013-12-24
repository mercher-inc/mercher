<?php
/**
 * @var $this ManagersController
 * @var $model Manager
 * @var $form ActiveForm
 * @var $adminsList array
 * @var $unknownUsersList array
 */

Yii::app()->controller->headerTitle = Yii::t(
    'manager',
    'edit'
);

    $form = $this->beginWidget(
        'ActiveForm',
        [
            'id'                   => 'manager-form',
            'enableAjaxValidation' => false,
            'htmlOptions'          => [
                'class'   => 'main-form',
                'enctype' => 'multipart/form-data'
            ]
        ]
    );

    Yii::app()->clientScript->registerPackage('bootstrap');
    Yii::app()->clientScript->registerScript(
        'manager-form-tooltips',
        "$('#manager-form *[data-toggle=\"tooltip\"]').tooltip();"
    );

    //==user_id==
    echo CHtml::openTag('div', ['class' => 'row']);
    echo CHtml::openTag(
        'div',
        ['class' => 'form-group col-lg-12']
    );
    echo $form->label($model, 'user_id', ['class' => 'control-label']);
    echo CHtml::tag('p', ['class'=>'form-control-static'], $model->user->name);
    echo CHtml::closeTag('div');
    echo CHtml::closeTag('div');

    //==rolesList==
    echo CHtml::openTag('div', ['class' => 'row']);
    echo CHtml::openTag(
        'div',
        ['class' => 'form-group col-lg-12' . ($model->hasErrors('rolesList') ? ' has-error' : '')]
    );
    echo $form->checkBoxList(
        $model,
        'rolesList',
        [
            AuthManager::ROLE_SHOP_MANAGER => Yii::t('manager', AuthManager::ROLE_SHOP_MANAGER),
            AuthManager::ROLE_PRODUCTS_MANAGER => Yii::t('manager', AuthManager::ROLE_PRODUCTS_MANAGER),
            AuthManager::ROLE_CATEGORIES_MANAGER => Yii::t('manager', AuthManager::ROLE_CATEGORIES_MANAGER),
        ]
    );
    echo $form->error($model, 'rolesList', ['class' => 'help-block']);
    echo CHtml::closeTag('div');
    echo CHtml::closeTag('div');

    //==submit==

    echo CHtml::openTag('div', ['class' => 'row']);
    echo CHtml::openTag('div', ['class' => 'form-group actions col-lg-12']);
    echo CHtml::submitButton(
        Yii::t('manager', 'save'),
        array(
            'class' => 'btn btn-primary'
        )
    );
    echo CHtml::closeTag('div');
    echo CHtml::closeTag('div');

    $this->endWidget();