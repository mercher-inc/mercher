<?php
/**
 * @var $this ProductsController
 * @var $product Product
 * @var $appId string
 */
?>
<html>
<head prefix="og: http://ogp.me/ns# fb: http://ogp.me/ns/fb# product: http://ogp.me/ns/product#">
    <meta property="fb:app_id"                       content="<?php echo $appId ?>" />
    <meta property="og:type"                         content="product" />
    <meta property="og:url"                          content="<?php echo Yii::app()->urlManager->createUrl('products/ogRead', ['product_id' => $product->id]) ?>" />
    <meta property="og:title"                        content="<?php echo $product->title ?>" />
    <meta property="og:image"                        content="https://s-static.ak.fbcdn.net/images/devsite/attachment_blank.png" />
    <meta property="product:original_price:amount"   content="Sample Original Price: " />
    <meta property="product:original_price:currency" content="Sample Original Price: " />
    <meta property="product:pretax_price:amount"     content="Sample Pre-tax Price: " />
    <meta property="product:pretax_price:currency"   content="Sample Pre-tax Price: " />
    <meta property="product:price:amount"            content="Sample Price: " />
    <meta property="product:price:currency"          content="Sample Price: " />
    <meta property="product:shipping_cost:amount"    content="Sample Shipping Cost: " />
    <meta property="product:shipping_cost:currency"  content="Sample Shipping Cost: " />
    <meta property="product:weight:value"            content="Sample Weight: Value" />
    <meta property="product:weight:units"            content="Sample Weight: Units" />
    <meta property="product:shipping_weight:value"   content="Sample Shipping Weight: Value" />
    <meta property="product:shipping_weight:units"   content="Sample Shipping Weight: Units" />
    <meta property="product:sale_price:amount"       content="Sample Sale Price: " />
    <meta property="product:sale_price:currency"     content="Sample Sale Price: " />
    <meta property="product:sale_price_dates:start"  content="Sample Sale Price Dates: Start" />
    <meta property="product:sale_price_dates:end"    content="Sample Sale Price Dates: End" />
</head>
<body>
<?php var_dump($product); ?>
<?php var_dump($product->image); ?>
</body>
</html>