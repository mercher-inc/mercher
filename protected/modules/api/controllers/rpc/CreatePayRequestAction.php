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

            $payRequest                               = new PayRequest();
            $payRequest->actionType                   = PayRequest::ACTION_TYPE_PAY_PRIMARY;
            $payRequest->currencyCode                 = CurrencyCode::CURRENCY_CODE_USD;
            $payRequest->feesPayer                    = PayRequest::FEES_PAYER_PRIMARY_RECEIVER;
            $payRequest->returnUrl                    = Yii::app()->createAbsoluteUrl('/index/test');
            $payRequest->cancelUrl                    = Yii::app()->createAbsoluteUrl('/index/test');
            $payRequest->requestEnvelope->detailLevel = "ReturnAll";

            $clientDetails = Yii::createComponent(
                [
                    'class'         => '\PayPalComponent\Field\ClientDetails',
                    'applicationId' => 'Mercher DEV'
                ]
            );

            $payRequest->clientDetails = $clientDetails;

            $receiver = Yii::createComponent(
                [
                    'class'       => '\PayPalComponent\Field\Receiver',
                    'amount'      => $order->total,
                    'email'       => Yii::app()->paypal->primaryEmail,
                    'paymentType' => 'SERVICE',
                    'primary'     => true,
                ]
            );
            $payRequest->receiverList->addReceiver($receiver);

            $receiver = Yii::createComponent(
                [
                    'class'       => '\PayPalComponent\Field\Receiver',
                    'amount'      => (ceil(($order->total * .95)*100))/100,
                    'email'       => $order->shop->pp_merchant_id,
                    'paymentType' => 'GOODS',
                    'primary'     => false,
                ]
            );
            $payRequest->receiverList->addReceiver($receiver);

            if (!$response = $payRequest->submit()) {
                //print_r($payRequest);
                throw new CHttpException(500);
            } else {
                if ($response instanceof PayResponse) {
                    $order->pay_key = $response->payKey;
                } else {
                    //print_r($response);
                    throw new CHttpException(500);
                }
            }

            $order->status = Order::STATUS_WAITING_FOR_PAYMENT;
            if (!$order->save()) {
                throw new CHttpException(500);
            }
            $order->refresh();
        }

        $model = $order->attributes;
        echo \CJSON::encode($model);
    }
}