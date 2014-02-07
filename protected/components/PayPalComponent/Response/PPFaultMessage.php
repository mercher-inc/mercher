<?php
/**
 * Project: mercher
 * Author: Dmitry Les
 * Date: 2/7/14
 * Time: 2:24 PM
 */

namespace PayPalComponent\Response;

use PayPalComponent\Response;

class PPFaultMessage extends Response
{
    public $error;
}