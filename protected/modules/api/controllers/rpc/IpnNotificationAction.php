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


class IpnNotificationAction extends CAction
{
    public function run()
    {
        Yii::log(print_r($_POST, true), 'info', 'IpnNotification');
    }
}