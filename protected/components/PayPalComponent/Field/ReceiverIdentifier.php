<?php
/**
 * Project: mercher
 * Author: Dmitry Les
 * Date: 2/24/14
 * Time: 2:03 PM
 */

namespace PayPalComponent\Field;

use PayPalComponent\Field;

class ReceiverIdentifier extends Field
{
    public function attributeNames()
    {
        return [
            'email',
            'accountId',
            'phone',
        ];
    }

    public function attributeLabels()
    {
        return [
            'email'     => 'Email',
            'accountId' => 'Account ID',
            'phone'     => 'Phone',
        ];
    }

    public function rules()
    {
        return [
        ];
    }
}