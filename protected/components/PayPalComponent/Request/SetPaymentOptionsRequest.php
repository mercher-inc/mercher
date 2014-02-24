<?php
/**
 * Project: mercher
 * Author: Dmitry Les
 * Date: 2/24/14
 * Time: 1:32 PM
 */

namespace PayPalComponent\Request;

use Yii,
    PayPalComponent\Request;

class SetPaymentOptionsRequest extends Request
{
    public function init()
    {
        $this->displayOptions = new \PayPalComponent\Field\DisplayOptions();
        $this->initiatingEntity = new \PayPalComponent\Field\InitiatingEntity();
        $this->senderOptions = new \PayPalComponent\Field\SenderOptions();
        $this->receiverOptions = new \PayPalComponent\Field\ReceiverOptions();
        $this->requestEnvelope = new \PayPalComponent\Field\RequestEnvelope();
    }

    public function endpoint()
    {
        return Yii::app()->paypal->baseUrl . 'AdaptivePayments/SetPaymentOptions';
    }

    public function attributeNames()
    {
        return [
            'payKey',
            'displayOptions',
            'initiatingEntity',
            'shippingAddressId',
            'senderOptions',
            'receiverOptions',
            'requestEnvelope',
        ];
    }

    public function attributeLabels()
    {
        return [
            'payKey'            => 'PayKey',
            'displayOptions'    => 'Display options',
            'initiatingEntity'  => 'Initiating entity',
            'shippingAddressId' => 'Shipping address ID',
            'senderOptions'     => 'Sender options',
            'receiverOptions'   => 'Receiver options',
            'requestEnvelope'   => 'Request envelope',
        ];
    }

    public function rules()
    {
        return [
            [
                ['payKey', 'requestEnvelope'],
                'required'
            ],
            [
                ['displayOptions', 'initiatingEntity', 'senderOptions', 'receiverOptions', 'requestEnvelope'],
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
                $response['class'] = '\PayPalComponent\Response\SetPaymentOptionsResponse';
                break;
        }
        return Yii::createComponent($response);
    }

}