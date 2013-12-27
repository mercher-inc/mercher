<?php
/**
 * @var $this WizardController
 * @var $model Shop
 * @var $accounts array
 * @var $form CActiveForm
 */

//FORM
$form = $this->beginWidget(
    'CActiveForm',
    [
        'id'                   => 'shop-form',
        'enableAjaxValidation' => false,
        'htmlOptions'          => [
            'class' => 'main-form'
        ]
    ]
);

Yii::app()->clientScript->registerPackage('bootstrap');
Yii::app()->clientScript->registerScript(
    'shop-form-tooltips',
    "$('#shop-form *[data-toggle=\"tooltip\"]').tooltip();"
);

echo CHtml::tag('legend', [], 'Select one of your Facebook pages to create shop for it');

echo CHtml::openTag('div', ['class' => 'row']);
echo CHtml::openTag('div', ['class' => 'form-group col-lg-12' . ($model->hasErrors('fb_id') ? ' has-error' : '')]);
echo $form->dropDownList(
    $model,
    'fb_id',
    $accounts,
    [
        'class'       => 'form-control',
        'data-toggle' => 'tooltip',
        'title'       => 'Select one of your Facebook pages to create shop for'
    ]
);
echo $form->error($model, 'fb_id', ['class' => 'help-block']);
echo CHtml::closeTag('div');
echo CHtml::closeTag('div');

echo CHtml::openTag('div', ['class' => 'row']);
echo CHtml::openTag('div', ['class' => 'form-group actions col-lg-12']);
echo CHtml::submitButton('Next', ['class' => 'btn btn-lg btn-danger']);
echo CHtml::closeTag('div');
echo CHtml::closeTag('div');

$this->endWidget();

if (!count($accounts)) {

    //CREATE_PAGE_DLG
    echo CHtml::openTag(
        'div',
        [
            'id'              => 'createPageDlg',
            'class'           => 'modal fade',
            'tabindex'        => '-1',
            'role'            => 'dialog',
            'aria-labelledby' => 'createPageDlgLabel',
            'aria-hidden'     => 'true',
        ]
    );
    echo CHtml::openTag('div', ['class' => 'modal-dialog']);
    echo CHtml::openTag('div', ['class' => 'modal-content']);
    echo CHtml::openTag('div', ['class' => 'modal-header']);
    echo CHtml::tag(
        'h4',
        [
            'id'    => 'createPageDlgLabel',
            'class' => 'modal-title',
        ],
        Yii::t('label', 'no_fb_pages_dlg_title')
    );
    echo CHtml::closeTag('div');
    echo CHtml::openTag('div', ['class' => 'modal-body']);
    echo CHtml::tag('p', [], Yii::t('label', 'no_fb_pages'));
    echo CHtml::closeTag('div');
    echo CHtml::openTag('div', ['class' => 'modal-footer']);
    echo CHtml::link(
        Yii::t('label', 'create_facebook_page'),
        '//www.facebook.com/pages/create.php',
        [
            'id'     => 'createPageBtn',
            'class'  => 'btn btn-primary',
            'target' => '_blank'
        ]
    );
    echo CHtml::closeTag('div');
    echo CHtml::closeTag('div');
    echo CHtml::closeTag('div');
    echo CHtml::closeTag('div');

    Yii::app()->clientScript->registerScript(
        'authErrorDlg',
        "$('#createPageDlg').modal({backdrop:'static', keyboard: false});"
    );

    Yii::app()->clientScript->registerScript(
        'checkPages',
        "
            var checkPagesInterval = setInterval(checkPages, 5000);
            function checkPages() {
                FB.api('/me/accounts', function(response){
                    if (typeof response.data != 'undefined') {
                        if (response.data.length) {
                            var accountsSelect = $('#Shop_fb_id');
                            accountsSelect.html('');
                            for (i in response.data) {
                                $('<option value=\''+response.data[i].id+'\'>'+response.data[i].name+'</option>').appendTo(accountsSelect);
                            }
                            clearInterval(checkPagesInterval);
                            $('#createPageDlg').modal('hide');
                        }
                    }
                });
            }
        ",
        ClientScript::POS_FB
    );
}
