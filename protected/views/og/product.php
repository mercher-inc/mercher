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

foreach ($product->ogParams as $property=>$content) {
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