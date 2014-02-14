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

        $payRequest                               = new PaymentDetailsRequest();
        $payRequest->payKey = $order->pay_key;
        $payRequest->requestEnvelope->detailLevel = "ReturnAll";

        if (!$response = $payRequest->submit()) {
            //print_r($payRequest);
            throw new CHttpException(500);
        } else {
            if ($response instanceof PaymentDetailsResponse) {
                //print_r($response);
                if ($response->status == PaymentDetailsResponse::STATUS_INCOMPLETE) {
                    $order->status = Order::STATUS_ACCEPTED;
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

        $model = $order->attributes;
        echo \CJSON::encode($model);
    }
}