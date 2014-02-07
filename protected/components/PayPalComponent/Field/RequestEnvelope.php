<?php
/**
 * Project: mercher
 * Author: Dmitry Les
 * Date: 2/7/14
 * Time: 2:56 PM
 */

namespace PayPalComponent\Field;

use PayPalComponent\Field;

class RequestEnvelope extends Field
{
    public function attributeNames()
    {
        return [
            'detailLevel',
            'errorLanguage',
        ];
    }

    public function attributeLabels()
    {
        return [
            'detailLevel' => 'Detail level',
            'errorLanguage' => 'Error language',
        ];
    }

    public function rules()
    {
        return [
            [
                ['errorLanguage'],
                'default',
                'value' => 'en_US'
            ],
            [
                ['errorLanguage'],
                'required'
            ]
        ];
    }
}