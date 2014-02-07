<?php
/**
 * Project: mercher
 * Author: Dmitry Les
 * Date: 2/7/14
 * Time: 3:24 PM
 */

namespace PayPalComponent\Field;

use PayPalComponent\Field;

class ReceiverList extends Field
{
    public function init()
    {
        $this->receiver = [];
    }

    public function attributeNames()
    {
        return [
            'receiver'
        ];
    }

    public function attributeLabels()
    {
        return [
            'receiver' => 'Receiver',
        ];
    }

    public function rules()
    {
        return [
            [
                ['receiver'],
                'required'
            ]
        ];
    }

    public function __toArray()
    {
        $data = [
            'receiver' => []
        ];
        foreach ($this->getAttribute('receiver') as $receiver) {
            $data['receiver'][] = $receiver->__toArray();
        }
        return $data;
    }

    public function addReceiver(Receiver $receiver)
    {
        $receiverList = $this->getAttribute('receiver');
        $receiverList[] = $receiver;
        $this->setAttribute('receiver', $receiverList);
    }

}