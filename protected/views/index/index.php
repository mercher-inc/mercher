<?php
/**
 * @var $this SiteController
 * @var $errorCode integer
 * @var $errorMessage string
 * @var $pages array
 */

$this->pageTitle = 'Facebook Shop Builder - Facebook Store Platform - ' . Yii::app()->name;

Yii::app()->clientScript->registerMetaTag(
    'Mercher: The easiest way to build an effective Facebook shop (F-store).',
    'description'
);

Yii::app()->clientScript->registerMetaTag(
    'facebook shop, facebook store, facebook shop application, social ecommerce software, social commerce platform, shop wizard',
    'keywords'
);

$ga_ctaButton = <<<JS
$("#ctaButton").click(function(){
    ga('send', 'event', 'CTA', 'click', 'CTA click');
});
JS;


Yii::app()->clientScript->registerScript(
    "ga_ctaButton",
    $ga_ctaButton
);

Yii::app()->clientScript->registerPackage('bootstrap');

if (isset($errorCode) and isset($errorMessage)) {

    echo CHtml::openTag(
        'div',
        [
            'id'              => 'authErrorDlg',
            'class'           => 'modal fade',
            'tabindex'        => '-1',
            'role'            => 'dialog',
            'aria-labelledby' => 'authErrorDlgLabel',
            'aria-hidden'     => 'true',
        ]
    );
    echo CHtml::openTag('div', ['class' => 'modal-dialog']);
    echo CHtml::openTag('div', ['class' => 'modal-content']);
    echo CHtml::openTag('div', ['class' => 'modal-header']);
    echo CHtml::tag(
        'button',
        [
            'class'        => 'close',
            'type'         => 'button',
            'data-dismiss' => 'modal',
            'aria-hidden'  => 'true',
        ],
        '&times;'
    );
    echo CHtml::tag(
        'h4',
        [
            'id'    => 'authErrorDlgLabel',
            'class' => 'modal-title',
        ],
        Yii::t('auth', 'error_' . $errorCode)
    );
    echo CHtml::closeTag('div');
    echo CHtml::openTag('div', ['class' => 'modal-body']);
    echo CHtml::tag('p', [], $errorMessage);
    echo CHtml::closeTag('div');
    echo CHtml::openTag('div', ['class' => 'modal-footer']);
    echo CHtml::tag(
        'button',
        [
            'class'        => 'btn btn-default',
            'type'         => 'button',
            'data-dismiss' => 'modal',
        ],
        'OK'
    );
    echo CHtml::closeTag('div');
    echo CHtml::closeTag('div');
    echo CHtml::closeTag('div');
    echo CHtml::closeTag('div');

    Yii::app()->clientScript->registerScript('authErrorDlg', "$('#authErrorDlg').modal();");
}

?>

<div class="hero">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 text-center">

                <h1 class="hero-heading-first">
                    Set Up Your Facebook Store
                </h1>

                <span class="hero-heading-second">
					It is
				</span>

                <div class="hero-circle-block">
                    <div class="hero-circle-holder">
                        <div class="hero-circle-item">
                            <?php echo Yii::t('label', 'fast'); ?>
                        </div>
                    </div>
                    <div class="hero-circle-holder">
                        <div class="hero-circle-item">
                            <?php echo Yii::t('label', 'easy'); ?>
                        </div>
                    </div>
                    <div class="hero-circle-holder">
                        <div class="hero-circle-item">
                            <?php echo Yii::t('label', 'cheap'); ?>
                        </div>
                    </div>
                </div>

                <div class="hero-get-started">
                    <a class="btn btn-lg" id="ctaButton" href="<?php echo Yii::app()->facebook->getLoginUrl() ?>"
                       target="_top"><?php echo Yii::t('label', 'get_started'); ?></a>
                </div>

            </div>

            <div class="col-lg-6 col-md-6 hidden-sm hidden-xs hidden-md">
                <div id="carousel" class="carousel slide" data-ride="carousel">
                    <div class="carousel-inner">
                        <div class="item active">
                            <img class="hero-img" src="/img/hero-img-1.jpg">
                        </div>
                        <div class="item">
                            <img class="hero-img" src="/img/hero-img-2.jpg">
                        </div>
                        <div class="item">
                            <img class="hero-img" src="/img/hero-img-3.jpg">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="container">
    <div id="hero-desc-block">
        <p>
            <strong>Facebook it - Sell it.</strong><br>
            And let your friends on Facebook become your loyal customers.<br>
            Mercher is the simplest way to add an online shop directly onto your Facebook!<br>
            <br>
            All you need is a <strong>Facebook Fan Page</strong> and a <strong>PayPal account</strong> to start taking orders.<br>
            No monthly cost. 2% Mercher fee <strong>only</strong> when you sell.<br>
            Try Mercher now and see for yourself!<br>
        </p>
    </div>
</div>

<!--
<div class="hero-customers">
    <div class="container">
        <h2>Our customers</h2>

        <div class="row">
            <?php
    	    if (isset($pages) and count($pages)) {
                foreach ($pages as $page) {
                    echo CHtml::tag(
                        'div',
                        ['class' => "col-xs-4 col-md-2"],
                        CHtml::link(
                            CHtml::image("https://graph.facebook.com/$page/picture?width=200&height=200", "", ["style"  => "width: 100%;"]),
                            "https://www.facebook.com/$page?sk=app_491297224259374",
                            [
                                "class"  => "thumbnail",
                                "target" => '_blank'
                            ]
                        )
                    );
                }
            }
            ?>
        </div>
    </div>
</div>
-->
<div class="hero-customers">
    <div class="container">
        <h2>Featured customers</h2>

        <div class="row">
            <div class="col-md-2 col-md-offset-2">
                <a href="https://www.facebook.com/176375372441230?sk=app_491297224259374" target="_blank" class="thumbnail">
                    <img src="/img/edm.jpg" style=""width: 100%;" />
                </a>
            </div>
            <div class="col-md-2">
                <a href="https://www.facebook.com/366963220127015?sk=app_491297224259374" target="_blank" class="thumbnail">
                    <img src="/img/thebeastincblack.png" style=""width: 100%;" />
                </a>
            </div>
            <div class="col-md-2">
                <a href="https://www.facebook.com/628065013907401?sk=app_491297224259374" target="_blank" class="thumbnail">
                    <img src="/img/dha.jpg" style=""width: 100%;" />
                </a>
            </div>
            <div class="col-md-2">
                <a href="https://www.facebook.com/314397168740080?sk=app_491297224259374" target="_blank" class="thumbnail">
                    <img src="/img/adora_bags.png" style=""width: 100%;" />
                </a>
            </div>
        </div>
    </div>
</div>
