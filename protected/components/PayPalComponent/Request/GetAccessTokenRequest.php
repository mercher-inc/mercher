<?php
/**
 * Project: mercher
 * Author: Dmitry Les
 * Date: 2/17/14
 * Time: 7:44 PM
 */

namespace PayPalComponent\Request;

use Yii,
    PayPalComponent\Request;

class GetAccessTokenRequest extends Request
{
    public function init()
    {
        $this->requestEnvelope = new \PayPalComponent\Field\RequestEnvelope();
    }

    public function endpoint()
    {
        return Yii::app()->paypal->baseUrl . 'Permissions/GetAccessToken';
    }

    public function attributeNames()
    {
        return [
            'token',
            'verifier',
            'subjectAlias',
            'requestEnvelope',
        ];
    }

    public function attributeLabels()
    {
        return [
            'token'           => 'Token',
            'verifier'        => 'Verifier',
            'subjectAlias'    => 'Subject alias',
            'requestEnvelope' => 'Request envelope',
        ];
    }


    public function rules()
    {
        return [
            [
                ['token', 'verifier', 'requestEnvelope'],
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
                $response['class'] = '\PayPalComponent\Response\GetAccessTokenResponse';
                break;
        }
        return Yii::createComponent($response);
    }
}