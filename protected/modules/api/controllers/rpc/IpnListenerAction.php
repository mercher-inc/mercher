<?php
/**
 * Project: mercher
 * Author: Dmitry Les
 * Date: 2/24/14
 * Time: 5:46 PM
 */

namespace api\controllers\rpc;

use Yii,
    CAction;


class IpnListenerAction extends CAction
{
    public function run()
    {
        /**
         * @var $request \CHttpRequest
         */
        $request =  Yii::app()->request;
        $data = $request->getRestParams();

        $req = http_build_query(array_merge(['cmd'=>'_notify-validate'], $data));

        $ch = curl_init('https://paypal.com/cgi-bin/webscr');
        curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $req);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
        curl_setopt($ch, CURLOPT_FORBID_REUSE, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Connection: Close'));

        if( !($res = curl_exec($ch)) ) {
            Yii::log(print_r($data, true), 'error', 'IpnNotification');
            curl_close($ch);
            exit;
        }
        curl_close($ch);

        if (strcmp ($res, "VERIFIED") == 0) {
            Yii::log(print_r($data, true), 'info', 'IpnNotification');
        } else if (strcmp ($res, "INVALID") == 0) {
            Yii::log(print_r($data, true), 'error', 'IpnNotification');
        }
    }
}