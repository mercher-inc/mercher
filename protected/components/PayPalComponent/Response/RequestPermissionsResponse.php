<?php
/**
 * Project: mercher
 * Author: Dmitry Les
 * Date: 2/17/14
 * Time: 7:24 PM
 */

namespace PayPalComponent\Response;

use PayPalComponent\Response;

class RequestPermissionsResponse extends Response
{
    public $token;
    public $responseEnvelope;
}