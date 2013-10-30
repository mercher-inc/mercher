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
                $('.hero-circle-arrow2').css('top', 370);
                $('.hero-circle-arrow2').show();
            } else {
                $('.hero-circle-holder a').removeClass('active');
                $('<a href=\"#hero-desc-index\"></a>').tab('show');
                $('.hero-circle-arrow').css('opacity', 0);
                $('.hero-circle-arrow2').css('top', 355);
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
            <div class="col-lg-6 col-md-6">
                <img class="hero-img" src="/img/hero-img-cheap.png">
            </div>
        </div>
    </div>
</div>

<div class="container">
    <div id="hero-desc-block" class="tab-content">
        <div class="tab-pane fade active in" id="hero-desc-index">
            <p>Suspendisse iaculis eros quis purus faucibus volutpat. Ut id justo nec ipsum posuere consequat sed sed
                urna. Maecenas consectetur bibendum rutrum. Curabitur tincidunt diam quis magna tincidunt, sit amet
                faucibus urna gravida. Vestibulum leo metus, malesuada vitae nibh eu, pulvinar volutpat diam. Vestibulum
                ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Sed fermentum consequat
                lectus sit amet suscipit. Integer metus purus, ultrices sed sapien nec, ultricies aliquet nunc.
                Pellentesque vel urna porta purus vestibulum suscipit et eget elit. Integer aliquam ullamcorper lectus,
                quis mollis lacus consequat suscipit. Morbi luctus tempus consequat. Nulla sed volutpat est, id varius
                mi. Nunc et orci nec quam ultricies suscipit quis in urna. Praesent ante erat, feugiat sed scelerisque
                nec, placerat varius leo. Proin sit amet turpis euismod, sagittis nulla in, porta diam. Curabitur tortor
                nulla, dapibus ac tellus cursus, feugiat tristique tellus.</p>
        </div>
        <div class="tab-pane fade" id="hero-desc-fast">
            <p>Duis sed erat nulla. Morbi porttitor egestas lectus, eu scelerisque turpis dapibus sit amet. Suspendisse
                ornare sit amet nunc vel pellentesque. Nunc sem ante, consectetur et dictum at, pharetra eget mi. Etiam
                scelerisque mattis est, in molestie diam egestas vel. Aenean ut faucibus erat. Nunc aliquam blandit
                nibh, vel pretium neque pretium non. Donec sed leo nec urna venenatis commodo vel nec massa. Aenean
                rutrum ac ligula faucibus mollis.</p>
        </div>
        <div class="tab-pane fade" id="hero-desc-easy">
            <p>Donec vulputate lacus turpis, non tempus velit accumsan in. Quisque ornare nunc quis sapien malesuada,
                vulputate lacinia lectus sodales. Quisque pharetra nulla ut nibh imperdiet pulvinar. Nullam vitae
                commodo ipsum, eu convallis erat. Sed consectetur, mi at viverra pharetra, purus augue fermentum erat,
                adipiscing feugiat mauris ante a lectus. Suspendisse semper commodo imperdiet. Cras ut urna sit amet
                nulla porttitor auctor ut id sapien. Etiam cursus pretium diam, sed sagittis massa hendrerit eget.
                Mauris fringilla imperdiet lectus, non laoreet diam aliquet eget.</p>
        </div>
        <div class="tab-pane fade" id="hero-desc-cheap">
            <p>Morbi sit amet bibendum dolor. Fusce nisi nulla, vulputate et urna quis, placerat aliquam turpis. Quisque
                vel lorem eu nunc bibendum scelerisque. Curabitur eu lectus dolor. Donec accumsan molestie tellus.
                Nullam sollicitudin, mi vulputate dignissim placerat, sapien risus fermentum metus, eu vulputate erat
                nibh a velit. Curabitur id nunc elit. Fusce ac leo facilisis, imperdiet nulla sed, tempor mauris.
                Maecenas interdum velit vel ullamcorper malesuada. Nulla tempor velit nec est tempor, non blandit sapien
                elementum. Maecenas dictum nulla et purus scelerisque elementum.</p>
        </div>
    </div>

    <div class="text-center">
        <a class="btn btn-primary btn-lg" href="<?php echo Yii::app()->facebook->getLoginUrl() ?>"
           target="_top"><?php echo Yii::t('label', 'get_started'); ?></a>
    </div>
</div>

<!--<button class="btn btn-primary btn-lg" onclick="FB.ui({method:'pagetab'});" >Add shop to your page</button>-->