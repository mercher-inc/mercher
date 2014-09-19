<?php
/**
 * @var $this ProductsController
 * @var $product Product
 * @var $shop Shop
 * @var $appId string
 */
?>
<html>
<head prefix="og: http://ogp.me/ns# fb: http://ogp.me/ns/fb# product: http://ogp.me/ns/product#">
    <meta property="fb:app_id" content="<?php echo $appId ?>" />
    <meta property="fb:profile_id" content="<?php echo $shop->fb_id ?>" />
    <meta property="fb:admins" content="<?php echo $shop->owner->fb_id ?>" />
    <meta property="og:type" content="product" />
    <meta property="og:url" content="<?php echo Yii::app()->urlManager->createUrl('products/ogRead', ['product_id' => $product->id]) ?>" />
    <meta property="og:title" content="<?php echo $product->title ?>" />
    <meta property="og:description" content="<?php echo $product->description ?>" />
    <meta property="og:rich_attachment" content="true" />
    <?php if ($product->image) { ?>
        <meta property="og:image" content="<?php echo 'https://mercher.net' . $product->image->getSize('l') ?>" />
    <?php } ?>
    <?php if ($product->price) { ?>
        <meta property="product:price:amount" content="<?php echo $product->price ?>" />
        <meta property="product:price:currency" content="USD" />
    <?php } ?>
    <?php if ($product->shipping) { ?>
        <meta property="product:shipping_cost:amount" content="<?php echo $product->shipping ?>" />
        <meta property="product:shipping_cost:currency" content="USD" />
    <?php } ?>
</head>
<body>
    <script>
        window.location.replace("https://www.facebook.com/<?php echo $shop->fb_id ?>?sk=app_<?php echo $appId ?>");
    </script>
</body>
</html>