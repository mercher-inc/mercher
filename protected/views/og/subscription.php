<?php
/**
 * @var $this OgController
 * @var $subscription Subscription
 */


echo CHtml::openTag('html');
echo CHtml::openTag(
    'head',
    [
        'prefix' => 'og: http://ogp.me/ns# fb: http://ogp.me/ns/fb# fbpayment: http://ogp.me/ns/fb/fbpayment#'
    ]
);

echo CHtml::tag(
    'meta',
    [
        'property' => 'og:title',
        'content'  => $subscription->title
    ]
);
echo CHtml::tag(
    'meta',
    [
        'property' => 'og:image',
        'content'  => $subscription->image
    ]
);
if ($subscription->description) {
    echo CHtml::tag(
        'meta',
        [
            'property' => 'og:description',
            'content'  => $subscription->description
        ]
    );
}
echo CHtml::tag(
    'meta',
    [
        'property' => 'fbpayment:price',
        'content'  => $subscription->price . ' USD'
    ]
);
if ($subscription->trial_duration) {
    echo CHtml::tag(
        'meta',
        [
            'property' => 'fbpayment:trial_duration',
            'content'  => $subscription->trial_duration . ' days'
        ]
    );
}
echo CHtml::tag(
    'meta',
    [
        'property' => 'fbpayment:billing_period',
        'content'  => '1 month'
    ]
);
echo CHtml::tag(
    'meta',
    [
        'property' => 'fb:app_id',
        'content'  => Yii::app()->facebook->sdk->getAppId()
    ]
);
echo CHtml::tag(
    'meta',
    [
        'property' => 'og:url',
        'content'  => $this->createAbsoluteUrl('', ['subscription_id' => $subscription->id])
    ]
);
echo CHtml::tag(
    'meta',
    [
        'property' => 'og:type',
        'content'  => 'fbpayment:subscription'
    ]
);

echo CHtml::closeTag('head');
echo CHtml::closeTag('html');
?>