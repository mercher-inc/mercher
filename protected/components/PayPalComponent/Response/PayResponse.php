<?php
/**
 * Project: mercher
 * Author: Dmitry Les
 * Date: 2/7/14
 * Time: 4:27 PM
 */

namespace PayPalComponent\Response;

use PayPalComponent\Response;

class PayResponse extends Response
{
    public $payKey;
    public $payErrorList;
    public $paymentExecStatus;
    public $paymentInfoList;
    public $sender;
    public $defaultFundingPlan;
    public $warningDataList;
}