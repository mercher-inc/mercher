<!DOCTYPE HTML>
<html lang="en">
<head>
    <title><?php echo CHtml::encode($this->pageTitle); ?></title>
</head>
<?php
$bodyClass = explode(' ', $this->bodyHtmlOptions['class']);
if (count($this->menu)) {
    $bodyClass[] = 'with-menu';
}
if ($this->headerTitle) {
    $bodyClass[] = 'with-title';
}
if (count($this->headerTable)) {
    $bodyClass[] = 'with-table';
}
$this->bodyHtmlOptions['class'] = implode(' ', $bodyClass);
echo CHtml::openTag('body', $this->bodyHtmlOptions);
?>
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
    <?php
    if ($this->headerTitle or count($this->headerButtons)) {
        echo CHtml::openTag('div', ['class' => 'navbar-main-title']);
        if (count($this->headerButtons)) {
            echo CHtml::openTag('div', ['class' => 'btn-group pull-right']);
            foreach ($this->headerButtons as $headerButton) {
                echo CHtml::link(
                    $headerButton['title'] ? $headerButton['title'] : '',
                    $headerButton['url'] ? $headerButton['url'] : '#',
                    [
                        'class' =>  'btn btn-primary'
                    ]
                );

            }
            echo CHtml::closeTag('div');
        }
        if ($this->headerTitle) {
            echo CHtml::tag('h1', [], $this->headerTitle);
        }
        echo CHtml::closeTag('div');
    }
    ?>
    <?php
    if (count($this->headerTable)) {
        echo CHtml::openTag('div', ['class' => 'navbar-main-table']);
        echo CHtml::openTag('table', ['style' => "width: 100%;"]);
        echo CHtml::openTag('tr');
        foreach ($this->headerTable as $th) {
            echo CHtml::tag('th', $th['htmlOptions'], $th['title'] ? $th['title'] : '');
        }
        echo CHtml::closeTag('tr');
        echo CHtml::closeTag('table');
        echo CHtml::closeTag('div');
    }
    ?>
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
