<?php
/**
 * Project: mercher
 * Author: Dmitry Les
 * Date: 2/14/14
 * Time: 1:29 PM
 */

namespace PayPalComponent\Response;

use PayPalComponent\Response;

class PaymentDetailsResponse extends Response
{
    const STATUS_CREATED = 'CREATED';
    const STATUS_COMPLETED = 'COMPLETED';
    const STATUS_INCOMPLETE = 'INCOMPLETE';
    const STATUS_ERROR = 'ERROR';
    const STATUS_REVERSAL_ERROR = 'REVERSALERROR';
    const STATUS_PROCESSING = 'PROCESSING';
    const STATUS_PENDING = 'PENDING';
    public $actionType;
    public $cancelUrl;
    public $currencyCode;
    public $feesPayer;
    public $fundingtypeList;
    public $ipnNotificationUrl;
    public $memo;
    public $payKey;
    public $payKeyExpirationDate;
    public $paymentInfoList;
    public $preapprovalKey;
    public $responseEnvelope;
    public $returnUrl;
    public $reverseAllParallelPaymentsOnError;
    public $sender;
    public $senderEmail;
    public $shippingAddress;
    public $status;
    public $trackingId;
}