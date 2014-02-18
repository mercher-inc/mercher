<?php

class m140217_180040_shop_pp_auth extends CDbMigration
{
    // tables
    const TABLE_SHOP     = 'shop';
    // types
    const TYPE_PAYPAL_PERMISSION = 't_paypal_permission';

    public $paypalPermissions = [
        'EXPRESS_CHECKOUT',
        'DIRECT_PAYMENT',
        'SETTLEMENT_CONSOLIDATION',
        'SETTLEMENT_REPORTING',
        'AUTH_CAPTURE',
        'MOBILE_CHECKOUT',
        'BILLING_AGREEMENT',
        'REFERENCE_TRANSACTION',
        'AIR_TRAVEL',
        'MASS_PAY',
        'TRANSACTION_DETAILS',
        'TRANSACTION_SEARCH',
        'RECURRING_PAYMENTS',
        'ACCOUNT_BALANCE',
        'ENCRYPTED_WEBSITE_PAYMENTS',
        'REFUND',
        'NON_REFERENCED_CREDIT',
        'BUTTON_MANAGER',
        'MANAGE_PENDING_TRANSACTION_STATUS',
        'RECURRING_PAYMENT_REPORT',
        'EXTENDED_PRO_PROCESSING_REPORT',
        'EXCEPTION_PROCESSING_REPORT',
        'ACCOUNT_MANAGEMENT_PERMISSION',
        'ACCESS_BASIC_PERSONAL_DATA',
        'ACCESS_ADVANCED_PERSONAL_DATA',
        'INVOICING',
    ];

	public function safeUp()
	{
        /*
         * TYPE_PAYPAL_PERMISSION
         */
        $this->execute(
            'CREATE TYPE ' . self::TYPE_PAYPAL_PERMISSION . ' AS ENUM (\'' . implode('\',\'', $this->paypalPermissions) . '\');'
        );

        /*
         * TABLE_USER
         */
        $this->addColumn(
            self::TABLE_SHOP,
            'paypal_scope',
            self::TYPE_PAYPAL_PERMISSION . '[]'
        );
        $this->addColumn(
            self::TABLE_SHOP,
            'paypal_token',
            'varchar(250)'
        );
        $this->addColumn(
            self::TABLE_SHOP,
            'paypal_token_secret',
            'varchar(250)'
        );
	}

	public function safeDown()
	{
        /*
         * TABLE_USER
         */
        $this->dropColumn(
            self::TABLE_SHOP,
            'paypal_token_secret'
        );
        $this->dropColumn(
            self::TABLE_SHOP,
            'paypal_token'
        );
        $this->dropColumn(
            self::TABLE_SHOP,
            'paypal_scope'
        );

        /*
         * TYPE_PAYPAL_PERMISSION
         */
        $this->execute('DROP TYPE ' . self::TYPE_PAYPAL_PERMISSION);
	}
}