<?php

class m131028_114649_pp extends CDbMigration
{
    // tables
    const TABLE_OBJECT   = 'object';
    const TABLE_SHOP     = 'shop';
    const TABLE_PRODUCT  = 'product';

	public function safeUp()
	{
        $this->addColumn(
            self::TABLE_SHOP,
            'pp_merchant_id',
            'varchar(50)'
        );

        $this->addColumn(
            self::TABLE_SHOP,
            'tax',
            'NUMERIC (6, 4) DEFAULT 0'
        );

        $this->renameColumn(
            self::TABLE_PRODUCT,
            'price',
            'amount'
        );

        $this->addColumn(
            self::TABLE_PRODUCT,
            'quantity_in_stock',
            'integer'
        );
	}

	public function safeDown()
	{
        $this->dropColumn(
            self::TABLE_PRODUCT,
            'quantity_in_stock'
        );

        $this->renameColumn(
            self::TABLE_PRODUCT,
            'amount',
            'price'
        );

        $this->dropColumn(
            self::TABLE_SHOP,
            'tax'
        );

        $this->dropColumn(
            self::TABLE_SHOP,
            'pp_merchant_id'
        );
	}
}