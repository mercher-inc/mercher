<?php
/* @var $this Controller */
/*
Yii::app()->clientScript->registerScript(
    'fb_get_profile',
    'FB.login(function(response) {' .
        'if (response.authResponse) {' .
        'console.log(\'Welcome!  Fetching your information.... \');' .
        'FB.api(\'/me\', function(response) {' .
        'console.log(\'Good to see you, \' + response.name + \'.\');' .
        '});' .
        '} else {' .
        'console.log(\'User cancelled login or did not fully authorize.\');' .
        '}' .
        '});',
    ClientScript::POS_FB
);
*/
Yii::app()->clientScript->registerMetaTag('text/html; charset=UTF-8', null, 'Content-Type');
Yii::app()->clientScript->registerMetaTag(
    'width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no',
    'viewport'
);
Yii::app()->clientScript->registerMetaTag('en', 'language');
?>
<!DOCTYPE HTML>
<html lang="en">
<head>
    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/style.css"/>
    <title><?php echo CHtml::encode($this->pageTitle); ?></title>
</head>

<body>
<div id="fb-root"></div>


<nav id="mainmenu" class="navbar navbar-default navbar-fixed-top" role="navigation">
    <div class="navbar-header">
        <a class="navbar-brand" href="<?php echo Yii::app()->urlManager->createUrl(Yii::app()->user->isGuest?'index/index':'shops/index') ?>"><?php echo CHtml::encode(
                Yii::app()->name
            ); ?></a>
    </div>
    <?php $this->widget(
        'zii.widgets.CMenu',
        array(
            'items'       => array(
                array(
                    'label'   => Yii::t('label', 'my_shops'),
                    'url'     => array('shops/index'),
                    'visible' => !Yii::app()->user->isGuest
                ),
                array(
                    'label'   => Yii::t('label', 'showcases'),
                    'url'     => array('showcases/index'),
                    'visible' => !Yii::app()->user->isGuest
                ),
            ),
            'htmlOptions' => array(
                'class' => 'nav navbar-nav'
            )
        )
    ); ?>
    <?php $this->widget(
        'zii.widgets.CMenu',
        array(
            'items'       => array(
                array('label' => 'About', 'url' => array('index/page', 'view' => 'about')),
                array('label' => 'Contact', 'url' => array('index/contact'), 'visible' => Yii::app()->user->isGuest),
                array('label' => 'Support', 'url' => array('support/index'), 'visible' => !Yii::app()->user->isGuest),
                array(
                    'label'   => 'Login',
                    'url'     => Yii::app()->facebook->getLoginUrl(),
                    'visible' => Yii::app()->user->isGuest,
                    'linkOptions' => array(
                        'target' => '_top'
                    )
                ),
                array(
                    'label'   => 'Logout (' . Yii::app()->user->name . ')',
                    'url'     => array('index/logout'),
                    'visible' => !Yii::app()->user->isGuest // and !Yii::app()->params['isApp']
                )
            ),
            'htmlOptions' => array(
                'class' => 'nav navbar-nav navbar-right'
            )
        )
    ); ?>
</nav>
<!-- mainmenu -->

<div id="page">
    <?php if (isset($this->breadcrumbs)): ?>
        <?php $this->widget('zii.widgets.CBreadcrumbs', array(
			'links'=>$this->breadcrumbs,
		)); ?><!-- breadcrumbs -->
    <?php endif ?>

    <?php echo $content; ?>

</div>
<!-- page -->

<hr/>
<footer>
    Copyright &copy; <?php echo date('Y'); ?> by Mercher.<br/>
    All Rights Reserved.<br/>
</footer>
<!-- footer -->

</body>
</html>
