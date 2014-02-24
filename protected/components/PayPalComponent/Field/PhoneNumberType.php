<?php
/**
 * Project: mercher
 * Author: Dmitry Les
 * Date: 2/24/14
 * Time: 2:05 PM
 */

namespace PayPalComponent\Field;

use PayPalComponent\Field;

class PhoneNumberType extends Field
{
    public function attributeNames()
    {
        return [
            'countryCode',
            'phoneNumber',
            'extension',
        ];
    }

    public function attributeLabels()
    {
        return [
            'countryCode' => 'Country code',
            'phoneNumber' => 'Phone number',
            'extension'   => 'Extension',
        ];
    }

    public function rules()
    {
        return [
        ];
    }
}