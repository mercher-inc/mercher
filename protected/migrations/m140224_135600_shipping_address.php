<?php

class m140224_135600_shipping_address extends CDbMigration
{
    // tables
    const TABLE_ORDER      = 'order';

	public function safeUp()
	{
        $this->addColumn(
            self::TABLE_ORDER,
            'sender_email',
            'varchar(250) NULL'
        );
        $this->addColumn(
            self::TABLE_ORDER,
            'shipping_address_addressee_name',
            'varchar(250) NULL'
        );
        $this->addColumn(
            self::TABLE_ORDER,
            'shipping_address_street1',
            'varchar(250) NULL'
        );
        $this->addColumn(
            self::TABLE_ORDER,
            'shipping_address_street2',
            'varchar(250) NULL'
        );
        $this->addColumn(
            self::TABLE_ORDER,
            'shipping_address_city',
            'varchar(250) NULL'
        );
        $this->addColumn(
            self::TABLE_ORDER,
            'shipping_address_state',
            'varchar(250) NULL'
        );
        $this->addColumn(
            self::TABLE_ORDER,
            'shipping_address_zip',
            'varchar(250) NULL'
        );
        $this->addColumn(
            self::TABLE_ORDER,
            'shipping_address_country',
            'varchar(250) NULL'
        );
	}

	public function safeDown()
	{
        $this->dropColumn(
            self::TABLE_ORDER,
            'sender_email'
        );
        $this->dropColumn(
            self::TABLE_ORDER,
            'shipping_address_addressee_name'
        );
        $this->dropColumn(
            self::TABLE_ORDER,
            'shipping_address_street1'
        );
        $this->dropColumn(
            self::TABLE_ORDER,
            'shipping_address_street2'
        );
        $this->dropColumn(
            self::TABLE_ORDER,
            'shipping_address_city'
        );
        $this->dropColumn(
            self::TABLE_ORDER,
            'shipping_address_state'
        );
        $this->dropColumn(
            self::TABLE_ORDER,
            'shipping_address_zip'
        );
        $this->dropColumn(
            self::TABLE_ORDER,
            'shipping_address_country'
        );
	}
}