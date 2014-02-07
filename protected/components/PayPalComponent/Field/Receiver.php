<?php
/**
 * Project: mercher
 * Author: Dmitry Les
 * Date: 2/7/14
 * Time: 3:26 PM
 */

namespace PayPalComponent\Field;

use PayPalComponent\Field;

class Receiver extends Field
{

    public function attributeNames()
    {
        return [
            'amount',
            'email',
            'accountId',
            'invoiceId',
            'paymentType',
            'paymentSubType',
            'phone',
            'primary',
        ];
    }

    public function attributeLabels()
    {
        return [
            'amount'         => 'Amount',
            'email'          => 'Email',
            'accountId'      => 'Account ID',
            'invoiceId'      => 'Invoice ID',
            'paymentType'    => 'Payment type',
            'paymentSubType' => 'Payment subtype',
            'phone'          => 'Phone',
            'primary'        => 'Primary',
        ];
    }

    public function rules()
    {
        return [
            [
                ['amount'],
                'required'
            ]
        ];
    }

}