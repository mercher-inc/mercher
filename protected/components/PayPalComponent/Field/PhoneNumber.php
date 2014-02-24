<?php
/**
 * Project: mercher
 * Author: Dmitry Les
 * Date: 2/24/14
 * Time: 1:59 PM
 */

namespace PayPalComponent\Field;

use PayPalComponent\Field;

class PhoneNumber extends Field
{
    public function attributeNames()
    {
        return [
            'type',
        ];
    }

    public function attributeLabels()
    {
        return [
            'type'    => 'Type',
        ];
    }

    public function rules()
    {
        return [
        ];
    }
}