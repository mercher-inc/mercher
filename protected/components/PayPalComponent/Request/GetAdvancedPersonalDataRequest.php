<?php
/**
 * Project: mercher
 * Author: Dmitry Les
 * Date: 2/18/14
 * Time: 11:59 AM
 */

namespace PayPalComponent\Request;

use Yii,
    PayPalComponent\Request;

class GetAdvancedPersonalDataRequest extends Request
{
    public function init()
    {
        $this->requestEnvelope = new \PayPalComponent\Field\RequestEnvelope();
    }

    public function endpoint()
    {
        return Yii::app()->paypal->baseUrl . 'Permissions/GetAdvancedPersonalData';
    }

    public function attributeNames()
    {
        return [
            'attributeList',
            'requestEnvelope',
        ];
    }

    public function attributeLabels()
    {
        return [
            'attributeList'          => 'Attribute list',
            'requestEnvelope' => 'Request envelope',
        ];
    }


    public function rules()
    {
        return [
            [
                ['attributeList', 'requestEnvelope'],
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
                $response['class'] = '\PayPalComponent\Response\GetAdvancedPersonalDataResponse';
                break;
        }
        return Yii::createComponent($response);
    }
}