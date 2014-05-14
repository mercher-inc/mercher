<!DOCTYPE HTML>
<html lang="en">
<head prefix="og: http://ogp.me/ns# fb: http://ogp.me/ns/fb# product: http://ogp.me/ns/product#">
    <title><?php echo CHtml::encode($this->pageTitle); ?></title>
</head>
<?php

$gaConfig = CJSON::encode(
    [
        'page'  => $this->route,
        'title' => $this->pageTitle
    ]
);

$ga = <<<JS
(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
})(window,document,'script','//www.google-analytics.com/analytics.js','ga');

ga('create', 'UA-23393444-14', 'mercher.net');
ga('set', $gaConfig);
ga('send', 'pageview');
JS;

Yii::app()->clientScript->registerScript('ga', $ga, CClientScript::POS_HEAD);

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
        <?php if (!Yii::app()->user->isGuest): ?>
        <div class="sidebarMenuBtn toggleSidebar"></div>
        <?php endif; ?>
        <a class="navbar-brand" href="<?php echo Yii::app()->controller->createUrl('index/index') ?>">
            Mercher,
            <br>
            the easiest way to build an
            <br>
            effective Facebook shop
        </a>
        <?php

        Yii::app()->clientScript->registerScript(
            'toggleSidebar',
            '
                $(".toggleSidebar").click(function(){
                    $("body").toggleClass("sidebarVisible");
                    return false;
                });
            '
        );
        ?>
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
    <?php
    $this->widget(
        'zii.widgets.CMenu',
        [
            'items'       => [
                [
                    'label'       => 'Login',
                    'url'         => Yii::app()->facebook->getLoginUrl(),
                    'visible'     => Yii::app()->user->isGuest,
                    'linkOptions' => [
                        'target' => '_top'
                    ]
                ],
                [
                    'label'          => Yii::app()->user->name,
                    'visible'        => !Yii::app()->user->isGuest,
                    'url'            => '#',
                    'linkOptions'    => [
                        'class'       => 'dropdown-toggle',
                        'data-toggle' => 'dropdown',
                    ],
                    'submenuOptions' => [
                        'class' => 'dropdown-menu',
                    ],
                    'items'          => [
                        [
                            'label'       => 'Invite friends',
                            'url'         => '#',
                            'linkOptions' => [
                                'id' => 'appRequestsBtn'
                            ]
                        ],
                        [
                            'label'       => 'On-line support',
                            'url'         => '//www.facebook.com/messages/mercher.net',
                            'linkOptions' => [
                                'target' => '_blank'
                            ]
                        ],
                        [
                            'itemOptions' => [
                                'class' => 'divider'
                            ]
                        ],
                        [
                            'label' => 'Logout',
                            'url'   => ['index/logout'],
                        ]
                    ]
                ]
            ],
            'htmlOptions' => [
                'class' => 'nav navbar-nav navbar-right'
            ]
        ]
    );

    Yii::app()->clientScript->registerPackage('bootstrap');

    if (!Yii::app()->user->isGuest) {
        Yii::app()->clientScript->registerScript(
            'appRequestsBtn',
            '
                $("#appRequestsBtn").click(function(){
                    FB.ui({
                        method: "apprequests",
                        message: "Try Mercher! It turns fan pages into shops."
                    }, function(response){

                    });
                });
            ',
            ClientScript::POS_FB
        );
    }
    ?>

    <div class="navbar-text navbar-right">
        <div class="fb-like" data-href="https://www.facebook.com/mercher.net" data-layout="button_count"
             data-action="like" data-show-faces="false" data-share="false"></div>
    </div>
</nav>
<!-- mainmenu -->

<?php
if ($this->headerTitle or count($this->headerButtons) or count($this->headerTable)) {
    echo CHtml::openTag('nav', ['class' => 'navbar navbar-contextual navbar-fixed-top', 'role' => 'navigation']);
    if (count($this->headerButtons)) {
        echo CHtml::openTag('div', ['class' => 'btn-group navbar-right']);
        foreach ($this->headerButtons as $headerButton) {
            if (!isset($headerButton['htmlOptions']) or !is_array($headerButton['htmlOptions'])) {
                $headerButton['htmlOptions'] = [];
            }
            if (isset($headerButton['htmlOptions']['class'])) {
                $headerButton['htmlOptions']['class'] .= ' btn navbar-btn';

                if (
                    !count(
                        array_intersect(
                            ['btn-default', 'btn-primary', 'btn-warning', 'btn-danger', 'btn-success', 'btn-info'],
                            explode(' ', $headerButton['htmlOptions']['class'])
                        )
                    )
                ) {
                    $headerButton['htmlOptions']['class'] .= ' btn-primary';
                }
            } else {
                $headerButton['htmlOptions']['class'] = 'btn btn-primary navbar-btn';
            }
            echo CHtml::link(
                $headerButton['title'] ? $headerButton['title'] : '',
                $headerButton['url'] ? $headerButton['url'] : '#',
                $headerButton['htmlOptions']
            );

        }
        echo CHtml::closeTag('div');
    }
    if ($this->headerTitle) {
        echo CHtml::openTag('div', ['class' => 'navbar-header']);
        echo CHtml::link($this->headerTitle, '#', ['class' => 'navbar-brand']);
        echo CHtml::closeTag('div');
    }
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
    echo CHtml::closeTag('nav');
}
?>

<?php if (!Yii::app()->user->isGuest): ?>
<div class="sidebar">
    <?php
    if (count($this->shopsMenu)) {
        echo CHtml::tag('h3', [], 'Shops');
        $this->widget(
            'zii.widgets.CMenu',
            [
                'items'       => $this->shopsMenu,
                'htmlOptions' => [
                    'class' => 'nav nav-pills nav-stacked'
                ]
            ]
        );
    }
    ?>

    <?php
    if (count($this->menu)) {
        echo CHtml::tag('h3', [], 'Management');
        $this->widget(
            'zii.widgets.CMenu',
            [
                'items'       => $this->menu,
                'htmlOptions' => [
                    'class' => 'nav nav-pills nav-stacked'
                ]
            ]
        );
    }
    ?>
</div>
<?php endif; ?>

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
