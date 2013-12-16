<?php
/**
 * @var $this OgController
 * @var $product Product
 */


echo CHtml::openTag('html');
echo CHtml::openTag(
    'head',
    [
        'prefix' => 'og: http://ogp.me/ns# fb: http://ogp.me/ns/fb# product: http://ogp.me/ns/product#'
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
        'property' => 'og:type',
        'content'  => 'product'
    ]
);
echo CHtml::tag(
    'meta',
    [
        'property' => 'og:url',
        'content'  => $this->createAbsoluteUrl('', ['product_id' => $product->id])
    ]
);
echo CHtml::tag(
    'meta',
    [
        'property' => 'og:title',
        'content'  => $product->title
    ]
);
if ($product->description) {
    echo CHtml::tag(
        'meta',
        [
            'property' => 'og:description',
            'content'  => $product->description
        ]
    );
}
if ($product->image_id) {
    $data = CJSON::decode($product->image->data);
    echo CHtml::tag(
        'meta',
        [
            'property' => 'og:image',
            'content'  => 'https://mercher.net' . $data['xl']
        ]
    );
}
if ($product->amount) {
    echo CHtml::tag(
        'meta',
        [
            'property' => 'product:price:amount',
            'content'  => $product->amount
        ]
    );
    echo CHtml::tag(
        'meta',
        [
            'property' => 'product:price:currency',
            'content'  => 'USD'
        ]
    );
}
if ($product->category_id) {
    echo CHtml::tag(
        'meta',
        [
            'property' => 'product:category',
            'content'  => $product->category->title
        ]
    );
}

echo CHtml::closeTag('head');
echo CHtml::closeTag('html');
?>