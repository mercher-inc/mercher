<?php
/**
 * Project: mercher
 * Author: Dmitry Les
 * Date: 2/6/14
 * Time: 8:29 PM
 */

namespace PayPalComponent;

class CurrencyCode
{
    const CURRENCY_CODE_AUD = 'AUD';
    const CURRENCY_CODE_BRL = 'BRL';
    const CURRENCY_CODE_CAD = 'CAD';
    const CURRENCY_CODE_CZK = 'CZK';
    const CURRENCY_CODE_DKK = 'DKK';
    const CURRENCY_CODE_EUR = 'EUR';
    const CURRENCY_CODE_HKD = 'HKD';
    const CURRENCY_CODE_HUF = 'HUF';
    const CURRENCY_CODE_ILS = 'ILS';
    const CURRENCY_CODE_JPY = 'JPY';
    const CURRENCY_CODE_MYR = 'MYR';
    const CURRENCY_CODE_MXN = 'MXN';
    const CURRENCY_CODE_NOK = 'NOK';
    const CURRENCY_CODE_NZD = 'NZD';
    const CURRENCY_CODE_PHP = 'PHP';
    const CURRENCY_CODE_PLN = 'PLN';
    const CURRENCY_CODE_GBP = 'GBP';
    const CURRENCY_CODE_SGD = 'SGD';
    const CURRENCY_CODE_SEK = 'SEK';
    const CURRENCY_CODE_CHF = 'CHF';
    const CURRENCY_CODE_TWD = 'TWD';
    const CURRENCY_CODE_THB = 'THB';
    const CURRENCY_CODE_TRY = 'TRY';
    const CURRENCY_CODE_USD = 'USD';

    public static function getList()
    {
        return [
            self::CURRENCY_CODE_AUD,
            self::CURRENCY_CODE_BRL,
            self::CURRENCY_CODE_CAD,
            self::CURRENCY_CODE_CZK,
            self::CURRENCY_CODE_DKK,
            self::CURRENCY_CODE_EUR,
            self::CURRENCY_CODE_HKD,
            self::CURRENCY_CODE_HUF,
            self::CURRENCY_CODE_ILS,
            self::CURRENCY_CODE_JPY,
            self::CURRENCY_CODE_MYR,
            self::CURRENCY_CODE_MXN,
            self::CURRENCY_CODE_NOK,
            self::CURRENCY_CODE_NZD,
            self::CURRENCY_CODE_PHP,
            self::CURRENCY_CODE_PLN,
            self::CURRENCY_CODE_GBP,
            self::CURRENCY_CODE_SGD,
            self::CURRENCY_CODE_SEK,
            self::CURRENCY_CODE_CHF,
            self::CURRENCY_CODE_TWD,
            self::CURRENCY_CODE_THB,
            self::CURRENCY_CODE_TRY,
            self::CURRENCY_CODE_USD,
        ];
    }
}