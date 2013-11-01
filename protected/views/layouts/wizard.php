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
            <?php echo CHtml::encode(Yii::app()->name); ?>
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
                <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 stepsHeader">
                    <h1>Create your</h1>
                    <h2>new shop</h2>
                </div>
                <div class="col-lg-2 col-md-2 hidden-sm hidden-xs step1btn">
                    <h1>1st</h1>
                    <h2>Step</h2>
                    <h3>Page</h3>
                </div>
                <div class="col-lg-2 col-md-2 hidden-sm hidden-xs step2btn">
                    <h1>2nd</h1>
                    <h2>Step</h2>
                    <h3>Category</h3>
                </div>
                <div class="col-lg-2 col-md-2 hidden-sm hidden-xs step3btn">
                    <h1>3rt</h1>
                    <h2>Step</h2>
                    <h3>Product</h3>
                </div>
                <div class="col-lg-2 col-md-2 hidden-sm hidden-xs step4btn">
                    <h2>Finish</h2>
                    <h3>Shop</h3>
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
        array(
            'items'       => array(
                array('label' => 'About', 'url' => array('index/page', 'view' => 'about')),
                array('label' => 'Contact', 'url' => array('index/contact')),
                array('label' => 'Support', 'url' => array('support/index')),
            ),
            'htmlOptions' => array(
                'class' => 'nav nav-pills nav-justified'
            )
        )
    ); ?>
    &copy;<?php echo date('Y'); ?> Mercher. All Rights Reserved.
</footer>
<!-- footer -->

</body>
</html>
