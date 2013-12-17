<?php
/**
 * @var $this OgController
 * @var $product Product
 */

$object = array(
    'og:title'             => $product->title,
    'og:locale'            => 'en_US',
    'fb:admins'            => $product->shop->owner->fb_id,
    'fb:app_id'            => Yii::app()->facebook->sdk->getAppId(),
    'product:retailer'     => $product->shop->fb_id
);
if ($product->amount) {
    $object['product:price:amount']   = $product->amount;
    $object['product:price:currency'] = 'USD';
}
if ($product->description) {
    $object['og:description'] = $product->description;
}

if ($product->category) {
    $object['product:category'] = $product->category->title;
}

if ($product->image) {
    $data               = CJSON::decode($product->image->data);
    $object['og:image'] = 'https://' . $_SERVER['HTTP_HOST'] . $data['xl'];
}

$object['og:url'] = Yii::app()->urlManager->createUrl('og/products', ['product_id' => $product->id]);

$object['product:product_link'] = 'http://www.facebook.com/' . $product->shop->fb_id . '?' . http_build_query(
    array(
        'sk'       => 'app_' . Yii::app()->facebook->sdk->getAppId(),
        'app_data' => CJSON::encode(
            array(
                'product_id' => $product->id
            )
        )
    )
);


echo CHtml::openTag('html');
echo CHtml::openTag(
    'head',
    [
        'prefix' => 'og: http://ogp.me/ns# fb: http://ogp.me/ns/fb# product: http://ogp.me/ns/product#'
    ]
);

foreach ($object as $property=>$content) {
    echo CHtml::tag(
        'meta',
        [
            'property' => $property,
            'content'  => $content
        ]
    );
}

echo CHtml::closeTag('head');
echo CHtml::closeTag('html');
?>