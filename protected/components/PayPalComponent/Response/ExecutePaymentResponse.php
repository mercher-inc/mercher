<?php
/**
 * Project: mercher
 * Author: Dmitry Les
 * Date: 2/17/14
 * Time: 5:44 PM
 */

namespace PayPalComponent\Response;

use PayPalComponent\Response;

class ExecutePaymentResponse extends Response
{
    const PAYMENT_EXEC_STATUS_CREATED       = 'CREATED';
    const PAYMENT_EXEC_STATUS_COMPLETED     = 'COMPLETED';
    const PAYMENT_EXEC_STATUS_INCOMPLETE    = 'INCOMPLETE';
    const PAYMENT_EXEC_STATUS_ERROR         = 'ERROR';
    const PAYMENT_EXEC_STATUS_REVERSALERROR = 'REVERSALERROR';

    public $payErrorList;
    public $paymentExecStatus;
    public $postPaymentDisclosureList;
    public $responseEnvelope;
}