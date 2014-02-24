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
        //$request->getRestParams();
        Yii::log(print_r($request->getRestParams(), true), 'info', 'IpnNotification');
    }
}