<?php
/**
 * Project: mercher
 * Author: Dmitry Les
 * Date: 2/7/14
 * Time: 6:01 PM
 */

namespace api\controllers;

use Yii,
    CHttpCookie;

class CartController extends \CController
{
    public function actionList($shop_id, $offset = 0, $limit = 10)
    {

    }

    public function actionRead($shop_id, $product_id)
    {

    }

    public function actionAdd()
    {
        D($this->cartKey);
    }

    public function actionOrder()
    {
        $payRequest                               = new \PayPalComponent\Request\PayRequest();
        $payRequest->actionType                   = \PayPalComponent\Request\PayRequest::ACTION_TYPE_PAY_PRIMARY;
        $payRequest->returnUrl                    = $this->createAbsoluteUrl('/index/test');
        $payRequest->cancelUrl                    = $this->createAbsoluteUrl('/index/test');
        $payRequest->currencyCode                 = \PayPalComponent\CurrencyCode::CURRENCY_CODE_USD;
        $payRequest->requestEnvelope->detailLevel = "ReturnAll";

        $clientDetails             = Yii::createComponent(
            [
                'class'         => '\PayPalComponent\Field\ClientDetails',
                'applicationId' => 'Mercher DEV'
            ]
        );
        $payRequest->clientDetails = $clientDetails;

        $receiver = Yii::createComponent(
            [
                'class'       => '\PayPalComponent\Field\Receiver',
                'amount'      => 1.00,
                'email'       => 'dmitriy.s.les-facilitator@gmail.com',
                'paymentType' => 'SERVICE',
                'primary'     => true,
            ]
        );
        $payRequest->receiverList->addReceiver($receiver);

        $receiver = Yii::createComponent(
            [
                'class'       => '\PayPalComponent\Field\Receiver',
                'amount'      => .95,
                'email'       => 'seller1.test@mercher.net',
                'paymentType' => 'GOODS',
                'primary'     => false,
            ]
        );
        $payRequest->receiverList->addReceiver($receiver);

        if (!$response = $payRequest->submit()) {
            D($payRequest, 1);
        } else {
            if ($response instanceof \PayPalComponent\Response\PayResponse) {
                D($response);
                echo CHtml::link(
                    'Pay',
                    'https://www.sandbox.paypal.com/cgi-bin/webscr?' . http_build_query(
                        [
                            'cmd'    => '_ap-payment',
                            'paykey' => $response->payKey
                        ]
                    ),
                    [
                        'target' => '_blank'
                    ]
                );
            } else {
                D($response, 1);
            }
        }
    }

    protected function getCartKey()
    {
        if (Yii::app()->request->cookies['cartKey'] === null) {
            Yii::app()->request->cookies['cartKey'] = new CHttpCookie(
                'cartKey',
                sha1(time() . rand()),
                [
                    'expire'   => strtotime('+10 years'),
                    'httpOnly' => true
                ]
            );
        }
        return (string)Yii::app()->request->cookies['cartKey'];
    }

}