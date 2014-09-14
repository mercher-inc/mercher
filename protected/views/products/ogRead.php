<?php
/**
 * @var $this ProductsController
 * @var $product Product
 * @var $appId string
 */
?>
<html>
<head prefix="og: http://ogp.me/ns# fb: http://ogp.me/ns/fb# product: http://ogp.me/ns/product#">
    <meta property="fb:app_id" content="<?php echo $appId ?>" />
    <meta property="og:type" content="product" />
    <meta property="og:url" content="<?php echo Yii::app()->urlManager->createUrl('products/ogRead', ['product_id' => $product->id]) ?>" />
    <meta property="og:title" content="<?php echo $product->title ?>" />
    <meta property="og:description" content="<?php echo $product->description ?>" />
    <?php if ($product->image) { ?>
        <meta property="og:image" content="<?php echo 'https://mercher.net' . $product->image->getSize('l') ?>" />
    <?php } ?>
    <?php if ($product->price) { ?>
        <meta property="product:price:amount" content="<?php echo $product->price ?>" />
        <meta property="product:price:currency" content="USD" />
    <?php } ?>
</head>
<body>
<?php var_dump($product); ?>
</body>
</html>