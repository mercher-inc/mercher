<?php
/**
 * Project: mercher
 * Author: Dmitry Les
 * Date: 2/24/14
 * Time: 1:57 PM
 */

namespace PayPalComponent\Field;

use PayPalComponent\Field;

class ShippingAddressInfo extends Field
{
    public function attributeNames()
    {
        return [
            'addresseeName',
            'street1',
            'street2',
            'city',
            'state',
            'zip',
            'country',
            'phone',
        ];
    }

    public function attributeLabels()
    {
        return [
            'addresseeName' => 'addresseeName',
            'street1'       => 'street1',
            'street2'       => 'street2',
            'city'          => 'city',
            'state'         => 'state',
            'zip'           => 'zip',
            'country'       => 'country',
            'phone'         => 'phone',
        ];
    }

    public function rules()
    {
        return [
        ];
    }
}