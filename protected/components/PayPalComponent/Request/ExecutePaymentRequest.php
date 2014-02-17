<?php
/**
 * Project: mercher
 * Author: Dmitry Les
 * Date: 2/17/14
 * Time: 5:41 PM
 */

namespace PayPalComponent\Request;

use Yii,
    PayPalComponent\Request;

class ExecutePaymentRequest extends Request
{
    public function init()
    {
        $this->requestEnvelope = new \PayPalComponent\Field\RequestEnvelope();
    }

    public function endpoint()
    {
        return Yii::app()->paypal->baseUrl . 'AdaptivePayments/ExecutePayment';
    }

    public function attributeNames()
    {
        return [
            'payKey',
            'actionType',
            'fundingPlanId',
            'requestEnvelope',
        ];
    }

    public function attributeLabels()
    {
        return [
            'payKey'          => 'PayKey',
            'actionType'      => 'Action type',
            'fundingPlanId'   => 'Funding plan ID',
            'requestEnvelope' => 'Request envelope',
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

    protected function parseResponse($response)
    {
        switch ($response['responseEnvelope']['ack']) {
            case 'Failure':
                $response['class'] = '\PayPalComponent\Response\PPFaultMessage';
                break;
            case 'Success':
                $response['class'] = '\PayPalComponent\Response\ExecutePaymentResponse';
                break;
        }
        return Yii::createComponent($response);
    }

}