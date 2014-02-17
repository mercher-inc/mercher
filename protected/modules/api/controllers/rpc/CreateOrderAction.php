<?php
/**
 * Project: mercher
 * Author: Dmitry Les
 * Date: 2/12/14
 * Time: 5:51 PM
 */

namespace api\controllers\rpc;

use Yii,
    CAction,
    CHttpException,
    Shop,
    User,
    CartItem,
    Product,
    Order,
    OrderItem,
    CDbCriteria;

class CreateOrderAction extends CAction
{
    public function run($shop_id)
    {
        $shop = Shop::model()->findByPk($shop_id);
        if (!$shop) {
            throw new CHttpException(404, \Yii::t('error', 'shop_not_found'));
        }

        $user = User::model()->findByPk(Yii::app()->user->id);

        $cartItems = CartItem::model()->findAll(
            [
                'with'      => 'product',
                'condition' => "product.shop_id = :shopId AND t.user_id = :userId",
                'params'    => [
                    'shopId' => $shop->id,
                    'userId' => $user->id
                ]
            ]
        );

        if (!count($cartItems)) {
            throw new CHttpException(404, Yii::t('rpc', 'Cart is empty'));
        }

        /**
         * @var $transaction \CDbTransaction
         */
        $transaction = Yii::app()->db->beginTransaction();

        $order          = new Order();
        $order->shop_id = $shop->id;
        $order->user_id = $user->id;
        $order->status  = Order::STATUS_NEW;

        if (!$order->save()) {
            $transaction->rollback();

            $errors = $order->getErrors();
            $a      = [];
            parse_str(http_build_query($errors), $a);
            echo \CJSON::encode(['errors' => $a]);

            header('HTTP/1.1 422 Unprocessable Entity');
            Yii::app()->end();
        }

        foreach ($cartItems as $cartItem) {
            $orderItem             = new OrderItem();
            $orderItem->order_id   = $order->id;
            $orderItem->product_id = $cartItem->product->id;
            $orderItem->price      = $cartItem->product->price;
            $orderItem->amount     = $cartItem->amount;

            if (!$orderItem->save()) {
                $transaction->rollback();

                $errors = $order->getErrors();
                $a      = [];
                parse_str(http_build_query($errors), $a);
                echo \CJSON::encode(['errors' => $a]);

                header('HTTP/1.1 422 Unprocessable Entity');
                Yii::app()->end();
            } else {
                $cartItem->delete();
            }
        }

        $order->refresh();
        $model = $order->attributes;
        echo \CJSON::encode($model);

        header('HTTP/1.1 201 Created');

        $transaction->commit();
    }
}