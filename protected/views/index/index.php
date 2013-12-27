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
Yii::app()->clientScript->registerScript(
    'heroTabs',
    "
        $('.hero-circle-holder a').click(function (e) {
            e.preventDefault();
            if (!$(e.target).hasClass('active')) {
                $('.hero-circle-holder a').removeClass('active');
                $(e.target).addClass('active');
                $(this).tab('show');

                $('.hero-circle-arrow').css('left', $(this).position().left + 45);
                $('.hero-circle-arrow').css('top', $(this).position().top + 140);
                $('.hero-circle-arrow').css('opacity', 1);
                $('.hero-circle-arrow').show();

                $('.hero-circle-arrow2').css('left', $(this).position().left + 45);
                $('.hero-circle-arrow2').css('top', $(this).position().top + 174);
                $('.hero-circle-arrow2').show();
            } else {
                $('.hero-circle-holder a').removeClass('active');
                $('<a href=\"#hero-desc-index\"></a>').tab('show');
                $('.hero-circle-arrow').css('opacity', 0);
                $('.hero-circle-arrow2').css('top', $(this).position().top + 163);
            }
        })
    "
);

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

                <span class="hero-heading-second"><?php echo Yii::t('label', 'it_is'); ?></span>

                <div class="hero-circle-block nav">
                    <div class="hero-circle-holder">
                        <a class="hero-circle-fast" href="#hero-desc-fast">
                            <?php echo Yii::t('label', 'fast'); ?>
                        </a>
                    </div>
                    <div class="hero-circle-holder">
                        <a class="hero-circle-easy" href="#hero-desc-easy">
                            <?php echo Yii::t('label', 'easy'); ?>
                        </a>
                    </div>
                    <div class="hero-circle-holder">
                        <a class="hero-circle-cheap" href="#hero-desc-cheap">
                            <?php echo Yii::t('label', 'cheap'); ?>
                        </a>
                    </div>
                </div>
                <div class="hero-circle-arrow2"></div>
                <div class="hero-circle-arrow"></div>
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
    <div id="hero-desc-block" class="tab-content">
        <div class="tab-pane fade active in" id="hero-desc-index">
            <p>
                Facebook it - Sell it.<br>
                And let your friends on Facebook become your loyal customers.<br>
                Mercher is the simplest way to add an online shop directly onto your Facebook!<br><br>
                All you need is a <strong>Facebook Fan Page</strong> and a <strong>PayPal email</strong> to start taking
                orders.<br>
                Stores with up to 10 items are <strong>free</strong>!
            </p>
        </div>
        <div class="tab-pane fade" id="hero-desc-fast">
            <p>
                With Mercher you need only 3 clicks to launch your Facebook&reg; store.
            </p>
        </div>
        <div class="tab-pane fade" id="hero-desc-easy">
            <p>
                The very simple and easy-to-understand procedure of the Facebook&reg; shop setting up.
            </p>
        </div>
        <div class="tab-pane fade" id="hero-desc-cheap">
            <p>
                A Facebook&reg; store with 10 items of goods is free and with a small fee for larger stores.
            </p>
        </div>
    </div>

    <div class="hero-get-started">
        <a class="btn btn-primary btn-lg" id="ctaButton" href="<?php echo Yii::app()->facebook->getLoginUrl() ?>"
           target="_top"><?php echo Yii::t('label', 'get_started'); ?></a>
    </div>

    <div class="hero-customers">
        <div class="row">
            <?php
            if (isset($pages) and count($pages)) {
                foreach ($pages as $page) {
                    echo CHtml::tag(
                        'div',
                        ['class' => "col-xs-4 col-md-2"],
                        CHtml::link(
                            CHtml::image("https://graph.facebook.com/$page/picture?width=200&height=200"),
                            "https://www.facebook.com/$page?sk=app_491297224259374",
                            [
                                "class"=> "thumbnail",
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

<!--<button class="btn btn-primary btn-lg" onclick="FB.ui({method:'pagetab'});" >Add shop to your page</button>-->