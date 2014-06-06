<?php
/**
 * Project: mercher
 * Author: Dmitry Les
 * Date: 2/14/14
 * Time: 12:53 PM
 */

namespace api\controllers\rpc;

use Yii,
    CAction,
    Order,
    User,
    CHttpException,
    \PayPalComponent\Request\PaymentDetailsRequest as PaymentDetailsRequest,
    \PayPalComponent\Response\PaymentDetailsResponse as PaymentDetailsResponse,
    \PayPalComponent\Response\PPFaultMessage as PPFaultMessage;

class CheckPaymentDetailsAction extends CAction
{
    public function run($order_id)
    {
        /**
         * @var $transaction \CDbTransaction
         */
        $transaction = Yii::app()->db->beginTransaction();

        $order = Order::model()->findByPk($order_id);
        if (!$order) {
            throw new CHttpException(404, Yii::t('error', 'order_not_found'));
        }

        $user = User::model()->findByPk(Yii::app()->user->id);

        if ($order->user_id != $user->id) {
            throw new CHttpException(403);
        }

        if (!$order->pay_key) {
            throw new CHttpException(500);
        }

        $paymentDetailsRequest                               = new PaymentDetailsRequest();
        $paymentDetailsRequest->payKey = $order->pay_key;
        $paymentDetailsRequest->requestEnvelope->detailLevel = "ReturnAll";

        if (!$response = $paymentDetailsRequest->submit()) {
            throw new CHttpException(500);
        } else {
            if ($response instanceof PaymentDetailsResponse) {
                if ($response->status == PaymentDetailsResponse::STATUS_COMPLETED) {
                    $order->status = Order::STATUS_ACCEPTED;
                    foreach ($order->orderItems(['with'=>'product']) as $orderItem) {
                        if ($orderItem->product->quantity_in_stock !== null) {
                            $orderItem->product->quantity_in_stock -= $orderItem->amount;
                            $orderItem->product->save();
                        }
                    }
                    if ($response->senderEmail) {
                        $order->sender_email = $response->senderEmail;
                    }
                    if ($response->shippingAddress) {
                        if (isset($response->shippingAddress['addresseeName'])) {
                            $order->shipping_address_addressee_name = $response->shippingAddress['addresseeName'];
                        }
                        if (isset($response->shippingAddress['street1'])) {
                            $order->shipping_address_street1 = $response->shippingAddress['street1'];
                        }
                        if (isset($response->shippingAddress['street2'])) {
                            $order->shipping_address_street2 = $response->shippingAddress['street2'];
                        }
                        if (isset($response->shippingAddress['city'])) {
                            $order->shipping_address_city = $response->shippingAddress['city'];
                        }
                        if (isset($response->shippingAddress['state'])) {
                            $order->shipping_address_state = $response->shippingAddress['state'];
                        }
                        if (isset($response->shippingAddress['zip'])) {
                            $order->shipping_address_zip = $response->shippingAddress['zip'];
                        }
                        if (isset($response->shippingAddress['country'])) {
                            $order->shipping_address_country = $response->shippingAddress['country'];
                        }
                    }
                    if (!$order->save()) {
                        throw new CHttpException(500);
                    }
                    $order->refresh();
                }
            } elseif ($response instanceof PPFaultMessage) {
                throw new CHttpException(500, $response->error[0]['message'], $response->error[0]['errorId']);
            } else {
                throw new CHttpException(500);
            }
        }

        $transaction->commit();

        $model = $order->attributes;
        echo \CJSON::encode($model);
    }
}