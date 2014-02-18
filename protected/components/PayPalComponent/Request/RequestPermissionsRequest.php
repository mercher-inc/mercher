<?php
/**
 * Project: mercher
 * Author: Dmitry Les
 * Date: 2/17/14
 * Time: 7:20 PM
 */

namespace PayPalComponent\Request;

use Yii,
    PayPalComponent\Request;

class RequestPermissionsRequest extends Request
{
    public function init()
    {
        $this->requestEnvelope = new \PayPalComponent\Field\RequestEnvelope();
    }

    public function endpoint()
    {
        return Yii::app()->paypal->baseUrl . 'Permissions/RequestPermissions';
    }

    public function attributeNames()
    {
        return [
            'scope',
            'callback',
            'requestEnvelope',
        ];
    }

    public function attributeLabels()
    {
        return [
            'scope'          => 'Scope',
            'callback'      => 'Callback',
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
                $response['class'] = '\PayPalComponent\Response\RequestPermissionsResponse';
                break;
            default:
                D($response, 1);
        }
        return Yii::createComponent($response);
    }
}