<!DOCTYPE HTML>
<html lang="en">
<head>
    <title><?php echo CHtml::encode($this->pageTitle); ?></title>
</head>
<body class="with-wizard">
<div id="fb-root"></div>
<nav id="mainmenu" class="navbar navbar-default navbar-fixed-top no-border" role="navigation">
    <div class="navbar-header">
        <a class="navbar-brand" href="<?php echo Yii::app()->controller->createUrl('index/index') ?>">
            Mercher,
            <br>
            the easiest way to build an
            <br>
            effective Facebook shop
        </a>
    </div>
    <?php $this->widget(
        'zii.widgets.CMenu',
        array(
            'items'       => array(
                array(
                    'label'       => 'Login',
                    'url'         => Yii::app()->facebook->getLoginUrl(),
                    'visible'     => Yii::app()->user->isGuest,
                    'linkOptions' => array(
                        'target' => '_top'
                    )
                ),
                array(
                    'label'   => 'Logout | ' . Yii::app()->user->name,
                    'url'     => array('index/logout'),
                    'visible' => !Yii::app()->user->isGuest // and !Yii::app()->params['isApp']
                )
            ),
            'htmlOptions' => array(
                'class' => 'nav navbar-nav navbar-right'
            )
        )
    ); ?>
    <div class="wizard-steps <?php echo $this->action->id ?>">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 stepsHeader">
                    <h1>Create your</h1>
                    <h2>new shop</h2>
                </div>
                <div class="col-lg-2 col-md-2 hidden-sm hidden-xs step1btn">
                    <h1>1st</h1>
                    <h2>Step</h2>
                    <h3>Page</h3>
                    <div class="arrow"></div>
                </div>
                <div class="col-lg-2 col-md-2 hidden-sm hidden-xs step2btn">
                    <h1>2nd</h1>
                    <h2>Step</h2>
                    <h3>Product</h3>
                    <div class="arrow"></div>
                </div>
                <div class="col-lg-2 col-md-2 hidden-sm hidden-xs step3btn">
                    <h1>3rd</h1>
                    <h2>Step</h2>
                    <h3>Shop</h3>
                    <div class="arrow"></div>
                </div>
            </div>
        </div>
    </div>
</nav>
<!-- mainmenu -->

<div id="page">

    <?php echo $content; ?>

</div>
<!-- page -->

<footer>
    <?php $this->widget(
        'zii.widgets.CMenu',
        [
            'items'       => [
                ['label' => Yii::t('label', 'policy'), 'url' => ['index/page', 'view' => 'policy']],
                ['label' => Yii::t('label', 'terms'), 'url' => ['index/page', 'view' => 'terms']],
                ['label' => Yii::t('label', 'contact'), 'url' => ['index/contact']],
            ],
            'htmlOptions' => [
                'class' => 'nav nav-pills nav-justified'
            ]
        ]
    ); ?>
    &copy;<?php echo date('Y'); ?> Mercher Inc. All Rights Reserved.
</footer>
<!-- footer -->

</body>
</html>
