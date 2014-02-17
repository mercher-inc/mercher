<?php
/**
 * Project: mercher
 * Author: Dmitry Les
 * Date: 2/17/14
 * Time: 6:14 PM
 */

namespace PayPalComponent\Request;

use Yii,
    PayPalComponent\Request;

class RefundRequest extends Request
{
    public function init()
    {
        $this->requestEnvelope = new \PayPalComponent\Field\RequestEnvelope();
    }

    public function endpoint()
    {
        return Yii::app()->paypal->baseUrl . 'AdaptivePayments/Refund';
    }

    public function attributeNames()
    {
        return [
            'currencyCode',
            'payKey',
            'receiverList',
            'requestEnvelope',
            'transactionId',
            'trackingId',
        ];
    }

    public function attributeLabels()
    {
        return [
            'currencyCode'    => 'Currency code',
            'payKey'          => 'PayKey',
            'receiverList'    => 'Receiver list',
            'requestEnvelope' => 'Request envelope',
            'transactionId'   => 'Transaction ID',
            'trackingId'      => 'Tracking ID',
        ];
    }


    public function rules()
    {
        return [
            [
                ['currencyCode', 'requestEnvelope'],
                'required'
            ],
            [
                ['receiverList', 'requestEnvelope'],
                'validateField'
            ]
        ];
    }

    protected function parseResponse($response)
    {
        switch ($response['responseEnvelope']['ack']) {
            case 'Failure':
                $response['class'] = '\PayPalComponent\Response\PPFaultMessage';
                break;
            case 'Success':
                $response['class'] = '\PayPalComponent\Response\RefundResponse';
                break;
        }
        return Yii::createComponent($response);
    }
}