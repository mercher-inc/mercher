<?php
/**
 * Project: mercher
 * Author: Dmitry Les
 * Date: 2/6/14
 * Time: 9:00 PM
 */

namespace PayPalComponent\Field;

use PayPalComponent\Field;

class ClientDetails extends Field
{
    public function attributeNames()
    {
        return [
            'applicationId',
            'customerId',
            'customerType',
            'deviceId',
            'geoLocation',
            'ipAddress',
            'model',
            'partnerName',
        ];
    }

    public function attributeLabels()
    {
        return [
            'applicationId' => 'Application ID',
            'customerId'    => 'Customer ID',
            'customerType'  => 'Customer type',
            'deviceId'      => 'Device ID',
            'geoLocation'   => 'Geo location',
            'ipAddress'     => 'IP address',
            'model'         => 'Model',
            'partnerName'   => 'Partner name',
        ];
    }
}