<?php
/**
 * Project: mercher
 * Author: Dmitry Les
 * Date: 2/24/14
 * Time: 1:49 PM
 */

namespace PayPalComponent\Field;

use PayPalComponent\Field;

class InitiatingEntity extends Field
{
    public function attributeNames()
    {
        return [
            'institutionCustomer',
        ];
    }

    public function attributeLabels()
    {
        return [
            'institutionCustomer' => 'Institution customer',
        ];
    }

    public function rules()
    {
        return [
        ];
    }
}