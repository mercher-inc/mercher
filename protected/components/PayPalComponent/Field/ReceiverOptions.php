<?php
/**
 * Project: mercher
 * Author: Dmitry Les
 * Date: 2/24/14
 * Time: 1:55 PM
 */

namespace PayPalComponent\Field;

use PayPalComponent\Field;

class ReceiverOptions extends Field
{
    public function init()
    {
        $this->receiver = new \PayPalComponent\Field\ReceiverIdentifier();
    }

    public function attributeNames()
    {
        return [
            'description',
            'customId',
            'invoiceData',
            'receiver',
        ];
    }

    public function attributeLabels()
    {
        return [
            'description' => 'Description',
            'customId'    => 'Custom ID',
            'invoiceData' => 'Invoice data',
            'receiver'    => 'Receiver',
        ];
    }

    public function rules()
    {
        return [
        ];
    }
}