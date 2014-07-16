<?php
/**
 * Project: mercher
 * Author: Dmitry Les
 * Date: 2/13/14
 * Time: 8:08 PM
 */

namespace api\controllers\rpc;

use Yii,
    CAction,
    Order,
    User,
    CHttpException,
    \PayPalComponent\Request\PayRequest as PayRequest,
    \PayPalComponent\Response\PayResponse as PayResponse,
    \PayPalComponent\Request\SetPaymentOptionsRequest as SetPaymentOptionsRequest,
    \PayPalComponent\Response\SetPaymentOptionsResponse as SetPaymentOptionsResponse,
    \PayPalComponent\Response\PPFaultMessage as PPFaultMessage,
    \PayPalComponent\CurrencyCode as CurrencyCode;

class CreatePayRequestAction extends CAction
{
    public function run($order_id)
    {
        $order = Order::model()->findByPk($order_id);
        if (!$order) {
            throw new CHttpException(404, Yii::t('error', 'order_not_found'));
        }

        $user = User::model()->findByPk(Yii::app()->user->id);

        if ($order->user_id != $user->id) {
            throw new CHttpException(403);
        }

        if ($order->status == Order::STATUS_NEW) {

            //================Prices calculation start================
            $amount     = 0;
            $shipping   = 0;
            $orderItems = $order->orderItems;
            $shop       = $order->shop;
            foreach ($orderItems as $orderItem) {
                $product = $orderItem->product;
                $amount += $product->price * $orderItem->amount;
                $shipping += $product->shipping * $orderItem->amount;
            }
            $taxes    = (ceil($amount * ($shop->tax / 100) * 100)) / 100;
            $total    = $amount + $shipping + $taxes;
            $fee      = (ceil($amount * Yii::app()->paypal->fee * 100)) / 100;
            var_dump($amount);
            var_dump($shipping);
            var_dump($taxes);
            var_dump($total);
            var_dump($fee);
            //=================Prices calculation end=================

            $payRequest               = new PayRequest();
            $payRequest->actionType   = PayRequest::ACTION_TYPE_PAY;
            $payRequest->currencyCode = CurrencyCode::CURRENCY_CODE_USD;
            $payRequest->feesPayer    = PayRequest::FEES_PAYER_PRIMARY_RECEIVER;
            /*
            $payRequest->returnUrl                    = Yii::app()->createAbsoluteUrl(
                '/api/rpc/check_payment_details',
                ['order_id' => $order->id]
            );
            $payRequest->cancelUrl                    = Yii::app()->createAbsoluteUrl(
                '/api/rpc/check_payment_details',
                ['order_id' => $order->id]
            );
            */
            $payRequest->returnUrl = Yii::app()->createAbsoluteUrl(
                '/tab/index/blank'
            );
            $payRequest->cancelUrl = Yii::app()->createAbsoluteUrl(
                '/tab/index/blank'
            );

            /*
            $payRequest->ipnNotificationUrl = Yii::app()->createAbsoluteUrl(
                '/api/rpc/ipn_listener'
            );
            */

            $payRequest->payKeyDuration               = 'PT1H';
            $payRequest->trackingId                   = $order->id;
            $payRequest->requestEnvelope->detailLevel = "ReturnAll";

            $clientDetails = Yii::createComponent(
                [
                    'class'         => '\PayPalComponent\Field\ClientDetails',
                    'applicationId' => 'Mercher'
                ]
            );

            $payRequest->clientDetails = $clientDetails;

            $receiver = Yii::createComponent(
                [
                    'class'       => '\PayPalComponent\Field\Receiver',
                    'amount'      => $total,
                    'email'       => $order->shop->pp_merchant_id,
                    'paymentType' => 'GOODS',
                    'primary'     => true,
                ]
            );
            $payRequest->receiverList->addReceiver($receiver);

            $receiver = Yii::createComponent(
                [
                    'class'       => '\PayPalComponent\Field\Receiver',
                    'amount'      => $fee,
                    'email'       => Yii::app()->paypal->primaryEmail,
                    'paymentType' => 'SERVICE',
                    'primary'     => false,
                ]
            );
            $payRequest->receiverList->addReceiver($receiver);

            if (!$payResponse = $payRequest->submit()) {
                throw new CHttpException(500);
            } else {
                if ($payResponse instanceof PayResponse) {
                    $order->pay_key = $payResponse->payKey;
                } elseif ($payResponse instanceof PPFaultMessage) {
                    throw new CHttpException(500, $payResponse->error[0]['message'], $payResponse->error[0]['errorId']);
                } else {
                    throw new CHttpException(500);
                }
            }

            $setPaymentOptionsRequest                                                 = new SetPaymentOptionsRequest();
            $setPaymentOptionsRequest->payKey                                         = $order->pay_key;
            $setPaymentOptionsRequest->displayOptions->businessName                   = 'Mercher';
            $setPaymentOptionsRequest->senderOptions->requireShippingAddressSelection = true;
            $setPaymentOptionsRequest->requestEnvelope->detailLevel                   = "ReturnAll";
            $setPaymentOptionsRequest->receiverOptions->receiver->email               = $order->shop->pp_merchant_id;

            $invoiceData = Yii::createComponent(
                [
                    'class'         => '\PayPalComponent\Field\InvoiceData',
                    'totalTax'      => $taxes,
                    'totalShipping' => $shipping
                ]
            );

            $setPaymentOptionsRequest->receiverOptions->invoiceData = $invoiceData;

            foreach ($orderItems as $orderItem) {
                $product     = $orderItem->product;
                $invoiceItem = Yii::createComponent(
                    [
                        'class'      => '\PayPalComponent\Field\InvoiceItem',
                        'name'       => $product->title,
                        'identifier' => $product->id,
                        'price'      => $product->price * $orderItem->amount,
                        'itemPrice'  => $product->price,
                        'itemCount'  => $orderItem->amount
                    ]
                );
                $setPaymentOptionsRequest->receiverOptions->invoiceData->addItem($invoiceItem);
            }

            if (!$setPaymentOptionsResponse = $setPaymentOptionsRequest->submit()) {
                throw new CHttpException(500);
            } else {
                if ($setPaymentOptionsResponse instanceof SetPaymentOptionsResponse) {
//                    print_r($setPaymentOptionsResponse);
//                    die;
                } elseif ($setPaymentOptionsResponse instanceof PPFaultMessage) {
                    throw new CHttpException(500, $setPaymentOptionsResponse->error[0]['message'], $setPaymentOptionsResponse->error[0]['errorId']);
                } else {
                    throw new CHttpException(500);
                }
            }


            $order->status  = Order::STATUS_WAITING_FOR_PAYMENT;
            $order->expires = new \CDbExpression('NOW() + \'1 hour\'');
            if (!$order->save()) {
                throw new CHttpException(500);
            }
            $order->refresh();
        }

        $model = $order->attributes;
        echo \CJSON::encode($model);
    }
}