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

    public function submitRequest(Request $request)
    {
        $requestData = $request->__toArray();

        //D($requestData, 1);

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $request->endpoint());
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt(
            $ch,
            CURLOPT_HTTPHEADER,
            [
                "X-PAYPAL-SECURITY-USERID: $this->userId",
                "X-PAYPAL-SECURITY-PASSWORD: $this->password",
                "X-PAYPAL-SECURITY-SIGNATURE: $this->signature",
                "X-PAYPAL-APPLICATION-ID: $this->applicationId",
                "X-PAYPAL-REQUEST-DATA-FORMAT: JSON",
                "X-PAYPAL-RESPONSE-DATA-FORMAT: JSON"
            ]
        );
        curl_setopt($ch, CURLOPT_POSTFIELDS, \CJSON::encode($requestData));
        $output = curl_exec($ch);
        curl_close($ch);

        $response = \CJSON::decode($output);

        return $response;
    }

}