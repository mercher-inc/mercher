<?php
/**
 * Project: mercher
 * Author: Dmitry Les
 * Date: 2/17/14
 * Time: 6:18 PM
 */

namespace PayPalComponent\Response;

use PayPalComponent\Response;

class RefundResponse extends Response
{
    public $currencyCode;
    public $refundInfoList;
    public $responseEnvelope;
}