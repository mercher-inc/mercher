<?php
/* @var $this SiteController */

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
?>

<div class="hero">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 col-md-6 text-center">
                <h1 class="hero-heading-first"><?php echo Yii::t('label', 'start_business_with_us'); ?></h1>
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
                <img class="hero-img" src="/img/hero-img-cheap.png">
            </div>
        </div>
    </div>
</div>

<div class="container">
    <div id="hero-desc-block" class="tab-content">
        <div class="tab-pane fade active in" id="hero-desc-index">
            <?php echo CHtml::tag('p', [], Yii::t('hero', 'index')); ?>
        </div>
        <div class="tab-pane fade" id="hero-desc-fast">
            <?php echo CHtml::tag('p', [], Yii::t('hero', 'fast')); ?>
        </div>
        <div class="tab-pane fade" id="hero-desc-easy">
            <?php echo CHtml::tag('p', [], Yii::t('hero', 'easy')); ?>
        </div>
        <div class="tab-pane fade" id="hero-desc-cheap">
            <?php echo CHtml::tag('p', [], Yii::t('hero', 'cheap')); ?>
        </div>
    </div>

    <div class="hero-get-started">
        <a class="btn btn-primary btn-lg" href="<?php echo Yii::app()->facebook->getLoginUrl() ?>"
           target="_top"><?php echo Yii::t('label', 'get_started'); ?></a>
    </div>
</div>

<!--<button class="btn btn-primary btn-lg" onclick="FB.ui({method:'pagetab'});" >Add shop to your page</button>-->