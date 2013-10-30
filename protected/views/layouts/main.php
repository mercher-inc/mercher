<!DOCTYPE HTML>
<html lang="en">
<head>
    <title><?php echo CHtml::encode($this->pageTitle); ?></title>
</head>
<body>
<div id="fb-root"></div>
<nav id="mainmenu" class="navbar navbar-default navbar-fixed-top" role="navigation">
    <div class="navbar-header">
        <a class="navbar-brand" href="<?php echo Yii::app()->urlManager->createUrl('shops/index') ?>">
            <?php echo CHtml::encode(Yii::app()->name); ?>
        </a>
    </div>
    <?php $this->widget(
        'zii.widgets.CMenu',
        array(
            'items'       => $this->menu,
            'htmlOptions' => array(
                'class' => 'nav navbar-nav navbar-left'
            )
        )
    ); ?>
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

<?php echo $this->renderPartial('//layouts/_footer'); ?>

</body>
</html>
