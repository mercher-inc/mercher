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

    public function __toArray()
    {
        $data = [
            'item'          => [],
            'totalTax'      => (float) $this->getAttribute('totalTax'),
            'totalShipping' => (float) $this->getAttribute('totalShipping'),
        ];
        foreach ($this->getAttribute('item') as $item) {
            $data['item'][] = $item->__toArray();
        }
        return $data;
    }

    public function addItem(InvoiceItem $item)
    {
        $itemList   = $this->getAttribute('item');
        $itemList[] = $item;
        $this->setAttribute('item', $itemList);
    }
}