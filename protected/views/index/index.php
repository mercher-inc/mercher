<?php
/**
 * @var $this SiteController
 * @var $errorCode integer
 * @var $errorMessage string
 */

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

$this->pageTitle = Yii::app()->name;

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
            <div class="col-lg-6 col-md-6 text-center">
                <h1 class="hero-heading-first">
                    Set Up Your Facebook Store
                </h1>

                <h1 class="hero-heading-second"><?php echo Yii::t('label', 'it_is'); ?></h1>

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
            <div class="col-lg-6 col-md-6 hidden-sm hidden-xs">
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
                Today Facebook is the largest social network. It means that a lot of your customers are present there.
                So, why not set up a Facebook shop right now? If your answer is that development of an online store
                isn't easy even on Facebook, you are in the right place: Mercher.net is just for you! Mercher is an
                effective but easy-to-use Facebook shop builder for non-techie users. As a social e-commerce software
                platform Mercher allows you to launch your shop fast, easy and for free for 10 items of goods - not so
                bad to start your online business, isn't it?
            </p>
        </div>
        <div class="tab-pane fade" id="hero-desc-fast">
            <p>
                With Mercher you need only 3 clicks to launch your Facebook store.
            </p>
        </div>
        <div class="tab-pane fade" id="hero-desc-easy">
            <p>
                The very simple and easy-to-understand procedure of the Facebook shop setting up.
            </p>
        </div>
        <div class="tab-pane fade" id="hero-desc-cheap">
            <p>
                A Facebook store with 10 items of goods is free and with a small fee for larger stores.
            </p>
        </div>
    </div>

    <div class="hero-get-started">
        <a class="btn btn-primary btn-lg" id="ctaButton" href="<?php echo Yii::app()->facebook->getLoginUrl() ?>"
           target="_top"><?php echo Yii::t('label', 'get_started'); ?></a>
    </div>
</div>

<!--<button class="btn btn-primary btn-lg" onclick="FB.ui({method:'pagetab'});" >Add shop to your page</button>-->