<?php
/**
 * Project: mercher
 * Author: Dmitry Les
 * Date: 2/17/14
 * Time: 7:48 PM
 */

namespace PayPalComponent\Response;

use PayPalComponent\Response;

class GetAccessTokenResponse extends Response
{
    public $scope;
    public $token;
    public $tokenSecret;
    public $responseEnvelope;
}