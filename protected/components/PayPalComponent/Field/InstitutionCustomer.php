<?php
/**
 * Project: mercher
 * Author: Dmitry Les
 * Date: 2/24/14
 * Time: 1:50 PM
 */

namespace PayPalComponent\Field;

use PayPalComponent\Field;

class InstitutionCustomer extends Field
{
    public function attributeNames()
    {
        return [
            'countryCode',
            'displayName',
            'email',
            'firstName',
            'institutionCustomerId',
            'institutionId',
            'lastName',
        ];
    }

    public function attributeLabels()
    {
        return [
            'countryCode'           => 'Country code',
            'displayName'           => 'Display name',
            'email'                 => 'Email',
            'firstName'             => 'First name',
            'institutionCustomerId' => 'Institution customer ID',
            'institutionId'         => 'Institution ID',
            'lastName'              => 'Last name',
        ];
    }

    public function rules()
    {
        return [
        ];
    }
}