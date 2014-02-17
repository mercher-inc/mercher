<?php
/**
 * @var $this OrdersController
 * @var $dataProvider CActiveDataProvider
 */
?>

<div class="view orders-index">
    <div class="container">
        <h1 class="page-header">
            <?= Yii::t('menu', 'Orders') ?>
        </h1>

        <div class="list">
            <?php foreach ($dataProvider->data as $order) : ?>
                <section class="view orders-index-item">
                    <div class="card <?= $order->status ?>">
                        <div class="row">
                            <div class="col-xs-1">
                                <a href="<?=
                                $this->createUrl(
                                    'read',
                                    ['shop_id' => $order->shop_id, 'order_id' => $order->id]
                                ) ?>">#<?= $order->id ?></a>
                            </div>
                            <div class="col-xs-2">
                                <?= Yii::app()->format->formatDate($order->created) ?>
                            </div>
                            <div class="col-xs-2">
                                <?=
                                CHtml::link(
                                    $order->user->name,
                                    'https://www.facebook.com/profile.php?id=' . $order->user->fb_id,
                                    [
                                        'target' => '_blank'
                                    ]
                                )
                                ?>
                            </div>
                            <div class="col-xs-3">
                                <div class="products">
                                    <?php foreach ($order->orderItems(
                                                       ['limit' => 10, 'order' => 'created']
                                                   ) as $orderItem) : ?>
                                        <a class="view orders-index-item-product" href="<?= $this->createUrl('/products/update', ['shop_id'=>$orderItem->product->shop_id, 'product_id'=>$orderItem->product->id]) ?>">
                                            <?php
                                            if ($orderItem->product->image) {
                                                echo CHtml::image(
                                                    $orderItem->product->image->getSize('xs'),
                                                    $orderItem->product->title
                                                );
                                            } else {
                                                echo CHtml::image(
                                                    '/img/logo_75.png',
                                                    $orderItem->product->title
                                                );
                                            }
                                            ?>
                                        </a>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                            <div class="col-xs-1">
                                <span class="total-sum">&#36;<?= $order->total ?></span>
                            </div>
                            <div class="col-xs-2">
                                <?php if ($order->status == Order::STATUS_ACCEPTED) { ?>
                                    <div class="btn-group btn-group-justified">
                                        <a class="btn btn-success" href="<?=
                                        $this->createUrl(
                                            'approve',
                                            ['shop_id' => $order->shop_id, 'order_id' => $order->id]
                                        ) ?>">Approve</a>
                                        <a class="btn btn-danger" href="<?=
                                        $this->createUrl(
                                            'reject',
                                            ['shop_id' => $order->shop_id, 'order_id' => $order->id]
                                        ) ?>">Reject</a>
                                    </div>
                                <?php
                                } else {
                                    switch ($order->status) {
                                        case Order::STATUS_NEW:
                                            echo 'New';
                                            break;
                                        case Order::STATUS_WAITING_FOR_PAYMENT:
                                            echo 'Waiting for payment';
                                            break;
                                        case Order::STATUS_APPROVED:
                                            echo 'Approved';
                                            break;
                                        case Order::STATUS_REJECTED:
                                            echo 'Rejected';
                                            break;
                                        case Order::STATUS_COMPLETED:
                                            echo 'Completed';
                                            break;
                                        default:
                                            echo $order->status;
                                    }
                                } ?>
                            </div>
                        </div>
                    </div>
                </section>
            <?php endforeach; ?>
        </div>
        <div class="pages">
            <?php
            $this->widget(
                'application.widgets.pagers.LinkPager',
                [
                    'pages' =>$dataProvider->pagination
                ]
            )
            ?>
        </div>
    </div>
</div>