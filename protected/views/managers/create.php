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
    'create'
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

//==userFbId==
echo CHtml::openTag('div', ['class' => 'row']);
echo CHtml::openTag(
    'div',
    ['class' => 'form-group col-lg-12' . ($model->hasErrors('userFbId') ? ' has-error' : '')]
);
echo $form->label($model, 'userFbId', ['class' => 'control-label']);
echo $form->dropDownList(
    $model,
    'userFbId',
    [],
    [
        'class'       => 'form-control',
        'data-toggle' => 'tooltip',
        'title'       => Yii::t('manager', 'help_userFbId')
    ]
);

echo $form->error($model, 'userFbId', ['class' => 'help-block']);
echo CHtml::closeTag('div');
echo CHtml::closeTag('div');

Yii::app()->clientScript->registerPackage('underscore');

Yii::app()->clientScript->registerScript(
    "loadFriendsListAsManagers",
    '
        $(\'#manager-form select[name="Manager[userFbId]"]\').prop("disabled", true);
        FB.getLoginStatus(function(response) {
            if (response.status === "connected") {
                FB.api(
                    "me/friends?fields=name,id&limit=1000",
                    function(response) {
                        if (response.data && response.data.length) {
                            _.each(response.data, function(profile){
                                $(\'#manager-form select[name="Manager[userFbId]"]\').append("<option value=\""+profile.id+"\">"+profile.name+"</option>");
                            });
                            $(\'#manager-form select[name="Manager[userFbId]"] option[value="'.$model->userFbId.'"]\').prop("selected", true);
                        }
                        $(\'#manager-form select[name="Manager[userFbId]"]\').prop("disabled", false);
                    }
                );
            }
        });
    ',
    ClientScript::POS_FB
);


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
    Yii::t('manager', 'create'),
    array(
        'class' => 'btn btn-primary'
    )
);
echo CHtml::closeTag('div');
echo CHtml::closeTag('div');

$this->endWidget();

