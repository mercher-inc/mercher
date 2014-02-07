<?php
/**
 * Project: mercher
 * Author: Dmitry Les
 * Date: 2/6/14
 * Time: 4:41 PM
 * @property string $actionType
 * @property string $cancelUrl
 * @property string $clientDetails
 * @property string $currencyCode
 * @property string $feesPayer
 * @property string $fundingConstraint
 * @property string $ipnNotificationUrl
 * @property string $memo
 * @property string $payKeyDuration
 * @property string $pin
 * @property string $preapprovalKey
 * @property string $receiverList
 * @property string $requestenvelope
 * @property string $returnUrl
 * @property string $reverseAllParallelPaymentsOnError
 * @property string $senderEmail
 * @property string $sender
 * @property string $trackingId
 */

namespace PayPalComponent\Request;

use Yii,
    PayPalComponent\Request;

class PayRequest extends Request
{
    const ACTION_TYPE_PAY         = 'PAY';
    const ACTION_TYPE_CREATE      = 'CREATE';
    const ACTION_TYPE_PAY_PRIMARY = 'PAY_PRIMARY';

    const FEES_PAYER_SENDER           = 'SENDER';
    const FEES_PAYER_PRIMARY_RECEIVER = 'PRIMARYRECEIVER';
    const FEES_PAYER_EACH_RECEIVER    = 'EACHRECEIVER';
    const FEES_PAYER_SECONDARY_ONLY   = 'SECONDARYONLY';

    public function init()
    {
        $this->receiverList = new \PayPalComponent\Field\ReceiverList();
        $this->requestEnvelope = new \PayPalComponent\Field\RequestEnvelope();
    }

    public function endpoint()
    {
        return 'https://svcs.sandbox.paypal.com/AdaptivePayments/Pay';
    }

    public function attributeNames()
    {
        return [
            'actionType',
            'cancelUrl',
            'clientDetails',
            'currencyCode',
            'feesPayer',
            'fundingConstraint',
            'ipnNotificationUrl',
            'memo',
            'payKeyDuration',
            'pin',
            'preapprovalKey',
            'receiverList',
            'requestEnvelope',
            'returnUrl',
            'reverseAllParallelPaymentsOnError',
            'senderEmail',
            'sender',
            'trackingId',
        ];
    }

    public function attributeLabels()
    {
        return [
            'actionType'                        => 'Action type',
            'cancelUrl'                         => 'Cancel URL',
            'clientDetails'                     => 'Client details',
            'currencyCode'                      => 'Currency code',
            'feesPayer'                         => 'Fees payer',
            'fundingConstraint'                 => 'Funding constraint',
            'ipnNotificationUrl'                => 'IPN notification URL',
            'memo'                              => 'Memo',
            'payKeyDuration'                    => 'Pay key duration',
            'pin'                               => 'PIN',
            'preapprovalKey'                    => 'Preapproval key',
            'receiverList'                      => 'Receiver list',
            'requestEnvelope'                   => 'Request envelope',
            'returnUrl'                         => 'Return URL',
            'reverseAllParallelPaymentsOnError' => 'Reverse all parallel payments on error',
            'senderEmail'                       => 'Sender email',
            'sender'                            => 'Sender',
            'trackingId'                        => 'Tracking ID',
        ];
    }

    public function rules()
    {
        return [
            [
                ['actionType', 'cancelUrl', 'currencyCode', 'receiverList', 'requestEnvelope', 'returnUrl'],
                'required'
            ],
            [
                ['clientDetails', 'receiverList', 'requestEnvelope'],
                'validateField'
            ]
        ];
    }

    public function setClientDetails($clientDetails)
    {
        if (is_array($clientDetails)) {
            if (!isset($clientDetails['class'])) {
                $clientDetails['class'] = '\PayPalComponent\ClientDetailsType';
            }
            $this->clientDetails = Yii::createComponent($clientDetails);
        } elseif ($clientDetails instanceof ClientDetailsType) {
            $this->clientDetails = $clientDetails;
        } else {
            throw new Exception();
        }
    }

    protected function parseResponse($response) {
        switch ($response['responseEnvelope']['ack']) {
            case 'Failure':
                $response['class'] = '\PayPalComponent\Response\PPFaultMessage';
                break;
            case 'Success':
                $response['class'] = '\PayPalComponent\Response\PayResponse';
                break;
        }
        return Yii::createComponent($response);
    }

    public function getClientDetails()
    {
        return $this->clientDetails;
    }

    public function getReceiverList()
    {
    }
}