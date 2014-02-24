<?php
/**
 * Project: mercher
 * Author: Dmitry Les
 * Date: 2/24/14
 * Time: 2:00 PM
 */

namespace PayPalComponent\Field;

use PayPalComponent\Field;

class InvoiceData extends Field
{
    public function attributeNames()
    {
        return [
            'item',
            'totalTax',
            'totalShipping',
        ];
    }

    public function attributeLabels()
    {
        return [
            'item'          => 'item',
            'totalTax'      => 'Total tax',
            'totalShipping' => 'Total shipping',
        ];
    }

    public function rules()
    {
        return [
        ];
    }
}