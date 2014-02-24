<?php
/**
 * @var $this ProductsController
 * @var $order Order
 */
?>

<div class="view orders-read">
    <div class="container">
        <h1 class="page-header">
            Order #<?= $order->id ?>
            <span class="status">
                <?php
                switch ($order->status) {
                    case Order::STATUS_NEW:
                        echo 'New';
                        break;
                    case Order::STATUS_WAITING_FOR_PAYMENT:
                        echo 'Waiting for payment';
                        break;
                    case Order::STATUS_ACCEPTED:
                        echo 'Accepted';
                        break;
                    case Order::STATUS_REJECTED:
                        echo 'Rejected';
                        break;
                    case Order::STATUS_APPROVED:
                        echo 'Approved';
                        break;
                    case Order::STATUS_COMPLETED:
                        echo 'Completed';
                        break;
                    default:
                        echo $order->status;
                }
                ?>
            </span>
        </h1>

        <?php if ($order->status == Order::STATUS_ACCEPTED) { ?>
            <div class="actions">
                <h2 class="page-header">Change order status</h2>
                <div class="btn-group btn-group-justified">
                    <a class="btn btn-success btn-lg" href="<?=
                    $this->createUrl(
                        'approve',
                        [
                            'shop_id'  => $order->shop_id,
                            'order_id' => $order->id
                        ]
                    ) ?>">Approve</a>
                    <a class="btn btn-danger btn-lg" href="<?=
                    $this->createUrl(
                        'reject',
                        [
                            'shop_id'  => $order->shop_id,
                            'order_id' => $order->id
                        ]
                    ) ?>">Reject</a>
                </div>
            </div>
        <?php } elseif ($order->status == Order::STATUS_APPROVED) { ?>
            <div class="actions">
                <h2 class="page-header">Change order status</h2>
                <div class="btn-group btn-group-justified">
                    <a class="btn btn-primary btn-lg" href="<?=
                    $this->createUrl(
                        'complete',
                        [
                            'shop_id'  => $order->shop_id,
                            'order_id' => $order->id
                        ]
                    ) ?>">Complete</a>
                    <a class="btn btn-danger btn-lg" href="<?=
                    $this->createUrl(
                        'reject',
                        [
                            'shop_id'  => $order->shop_id,
                            'order_id' => $order->id
                        ]
                    ) ?>">Reject</a>
                </div>
            </div>
        <?php } ?>

        <?php if ($order->sender_email or $order->shipping_address_addressee_name or $order->shipping_address_street1 or $order->shipping_address_street2 or $order->shipping_address_city or $order->shipping_address_state or $order->shipping_address_zip or $order->shipping_address_country) : ?>
            <div class="shipping-address">
                <h2 class="page-header">Shipping address</h2>
                <address>
                    <?php if ($order->shipping_address_addressee_name) : ?>
                        <strong><?= $order->shipping_address_addressee_name ?></strong><br>
                    <?php endif; ?>

                    <abbr title="Profile">P</abbr>: <?= CHtml::link(
                        $order->user->name,
                        'https://www.facebook.com/profile.php?id=' . $order->user->fb_id,
                        [
                            'target' => '_blank'
                        ]
                    ) ?>
                    <br>

                    <?php if ($order->shipping_address_street1) {
                        echo $order->shipping_address_street1;
                        if ($order->shipping_address_street2) {
                            echo ', ';
                        }
                    } ?>

                    <?php if ($order->shipping_address_street2) : ?>
                        <?= $order->shipping_address_street2 ?>
                    <?php endif; ?>

                    <?php if ($order->shipping_address_street1 || $order->shipping_address_street2) : ?>
                        <br>
                    <?php endif; ?>

                    <?php if ($order->shipping_address_city) {
                        echo $order->shipping_address_city;
                        if ($order->shipping_address_state || $order->shipping_address_zip) {
                            echo ', ';
                        }
                    } ?>

                    <?php if ($order->shipping_address_state) : ?>
                        <?= $order->shipping_address_state ?>
                    <?php endif; ?>

                    <?php if ($order->shipping_address_zip) : ?>
                        <?= $order->shipping_address_zip ?>
                    <?php endif; ?>

                    <?php if ($order->shipping_address_city || $order->shipping_address_state || $order->shipping_address_zip) : ?>
                        <br>
                    <?php endif; ?>

                    <?php if ($order->shipping_address_country) : ?>
                        <?= $order->shipping_address_country ?>
                        <br>
                    <?php endif; ?>

                    <?php if ($order->sender_email) : ?>
                        <abbr title="Email">E</abbr>: <a href="mailto:<?= $order->sender_email ?>"><?= $order->sender_email ?></a>
                        <br>
                    <?php endif; ?>

                </address>
            </div>
        <?php endif; ?>

        <div class="order-items">
            <h2 class="page-header">Order items</h2>
            <?php foreach ($order->orderItems(
                               ['limit' => -1, 'order' => 'created']
                           ) as $orderItem) : ?>
                <section class="view orders-read-item">
                    <span class="amount"><?= $orderItem->amount ?> &times;</span>

                    <div class="media">
                        <a class="pull-left" href="<?=
                        $this->createUrl(
                            '/products/update',
                            [
                                'shop_id'    => $orderItem->product->shop_id,
                                'product_id' => $orderItem->product->id
                            ]
                        ) ?>">
                            <?php if ($orderItem->product->image_id) { ?>
                                <img class="media-object img-circle"
                                     src="<?= $orderItem->product->image->getSize('xs') ?>">
                            <?php } ?>
                        </a>

                        <div class="media-body">
                            <h4 class="media-heading"><?= $orderItem->product->title ?></h4>

                            <p>&#36;<?= $orderItem->price ?></p>

                        </div>
                    </div>
                </section>
            <?php endforeach; ?>
            <div class="total-line">
                Total: <span class="total-sum">&#36;<?= $order->total ?></span>
            </div>
        </div>
    </div>
</div>