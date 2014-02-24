<?php
/**
 * Project: mercher
 * Author: Dmitry Les
 * Date: 2/24/14
 * Time: 1:37 PM
 */

namespace PayPalComponent\Field;

use PayPalComponent\Field;

class DisplayOptions extends Field
{
    public function attributeNames()
    {
        return [
            'emailHeaderImageUrl',
            'emailMarketingImageUrl',
            'headerImageUrl',
            'businessName',
        ];
    }

    public function attributeLabels()
    {
        return [
            'emailHeaderImageUrl'    => 'Email header image URL',
            'emailMarketingImageUrl' => 'Email marketing image URL',
            'headerImageUrl'         => 'Header image URL',
            'businessName'           => 'Business name',
        ];
    }

    public function rules()
    {
        return [
        ];
    }
}