<?php
/**
 * Project: mercher
 * Author: Dmitry Les
 * Date: 2/24/14
 * Time: 2:02 PM
 */

namespace PayPalComponent\Field;

use PayPalComponent\Field;

class InvoiceItem extends Field
{
    public function attributeNames()
    {
        return [
            'name',
            'identifier',
            'price',
            'itemPrice',
            'itemCount',
        ];
    }

    public function attributeLabels()
    {
        return [
            'name'       => 'Name',
            'identifier' => 'Identifier',
            'price'      => 'Price',
            'itemPrice'  => 'Item price',
            'itemCount'  => 'Item count',
        ];
    }

    public function rules()
    {
        return [
        ];
    }
}