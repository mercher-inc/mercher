<?php
/**
 * Project: mercher
 * Author: Dmitry Les
 * Date: 2/24/14
 * Time: 1:53 PM
 */

namespace PayPalComponent\Field;

use PayPalComponent\Field;

class SenderOptions extends Field
{
    public function attributeNames()
    {
        return [
            'requireShippingAddressSelection',
            'referrerCode',
            'addressOverride',
            'shippingAddress',
        ];
    }

    public function attributeLabels()
    {
        return [
            'requireShippingAddressSelection' => 'Require shipping address selection',
            'referrerCode'                    => 'Referrer code',
            'addressOverride'                 => 'Address override',
            'shippingAddress'                 => 'Shipping address',
        ];
    }

    public function rules()
    {
        return [
            [
                ['requireShippingAddressSelection', 'addressOverride'],
                'boolean',
            ]
        ];
    }
}