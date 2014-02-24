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

        <dl class="dl-horizontal">
            <dt><?= $order->getAttributeLabel('user') ?></dt>
            <dd><?=
                CHtml::link(
                    $order->user->name,
                    'https://www.facebook.com/profile.php?id=' . $order->user->fb_id,
                    [
                        'target' => '_blank'
                    ]
                )
                ?></dd>
        </dl>

        <?php if ($order->status == Order::STATUS_ACCEPTED) { ?>
            <div class="btn-group btn-group-justified actions">
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
        <?php } elseif ($order->status == Order::STATUS_APPROVED) { ?>
            <div class="btn-group btn-group-justified actions">
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
        <?php } ?>

        <div class="order-items">
            <?php foreach ($order->orderItems(
                               ['limit' => -1, 'order' => 'created']
                           ) as $orderItem) : ?>
                <section class="view orders-read-item">
                    <span class="amount"><?= $orderItem->amount ?> &times;</span>
                    <div class="media">
                        <a class="pull-left" href="<?= $this->createUrl(
                            '/products/update',
                            [
                                'shop_id'    => $orderItem->product->shop_id,
                                'product_id' => $orderItem->product->id
                            ]
                        ) ?>">
                            <?php if ($orderItem->product->image_id) { ?>
                                <img class="media-object img-circle" src="<?= $orderItem->product->image->getSize('xs') ?>">
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