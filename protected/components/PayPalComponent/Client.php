<?php
/**
 * Project: mercher
 * Author: Dmitry Les
 * Date: 2/6/14
 * Time: 4:34 PM
 */

namespace PayPalComponent;

use Yii,
    CApplicationComponent;

class Client extends CApplicationComponent
{
    public $userId;
    public $password;
    public $signature;
    public $applicationId;
    public $primaryEmail;
    public $baseUrl;
    public $fee;

    public function submitRequest(Request $request)
    {
        $requestData = $request->__toArray();

        if ($request instanceof Request\SetPaymentOptionsRequest) {
            var_dump($requestData); die;
        }

        $headers = [
            "X-PAYPAL-REQUEST-DATA-FORMAT: JSON",
            "X-PAYPAL-RESPONSE-DATA-FORMAT: JSON"
        ];
        $headers[] = "X-PAYPAL-APPLICATION-ID: $this->applicationId";

        if ($request->authHeader) {
            $headers[] = "X-PAYPAL-AUTHORIZATION: $request->authHeader";
        } else {
            $headers[] = "X-PAYPAL-SECURITY-USERID: $this->userId";
            $headers[] = "X-PAYPAL-SECURITY-PASSWORD: $this->password";
            $headers[] = "X-PAYPAL-SECURITY-SIGNATURE: $this->signature";
        }

        //D($requestData, 1);

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $request->endpoint());
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt(
            $ch,
            CURLOPT_HTTPHEADER,
            $headers
        );
        curl_setopt($ch, CURLOPT_POSTFIELDS, \CJSON::encode($requestData));
        $output = curl_exec($ch);
        curl_close($ch);

        $response = \CJSON::decode($output);

        return $response;
    }

}