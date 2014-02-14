<?php
/**
 * Project: mercher
 * Author: Dmitry Les
 * Date: 2/14/14
 * Time: 1:18 PM
 */

namespace PayPalComponent\Request;

use Yii,
    PayPalComponent\Request;

class PaymentDetailsRequest extends Request
{
    public function init()
    {
        $this->requestEnvelope = new \PayPalComponent\Field\RequestEnvelope();
    }

    public function endpoint()
    {
        return 'https://svcs.sandbox.paypal.com/AdaptivePayments/PaymentDetails';
    }

    public function attributeNames()
    {
        return [
            'payKey',
            'requestEnvelope',
            'transactionId',
            'trackingId',
        ];
    }

    public function attributeLabels()
    {
        return [
            'payKey'          => 'PayKey',
            'requestEnvelope' => 'Request envelope',
            'transactionId'   => 'Transaction ID',
            'trackingId'      => 'Tracking ID',
        ];
    }


    public function rules()
    {
        return [
            [
                ['requestEnvelope'],
                'required'
            ],
            [
                ['requestEnvelope'],
                'validateField'
            ]
        ];
    }

    protected function parseResponse($response) {
        switch ($response['responseEnvelope']['ack']) {
            case 'Failure':
                $response['class'] = '\PayPalComponent\Response\PPFaultMessage';
                break;
            case 'Success':
                $response['class'] = '\PayPalComponent\Response\PaymentDetailsResponse';
                break;
        }
        return Yii::createComponent($response);
    }
}