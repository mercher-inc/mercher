<?php

class m140716_171922_tax_and_shipping extends CDbMigration
{
    // tables
    const TABLE_SHOP    = 'shop';
    const TABLE_PRODUCT = 'product';

    public function safeUp()
    {
        $this->addColumn(
            self::TABLE_SHOP,
            'tax',
            'NUMERIC (6, 4) DEFAULT 0'
        );
        $this->addColumn(
            self::TABLE_PRODUCT,
            'shipping',
            'NUMERIC (9, 2) DEFAULT NULL'
        );
    }

    public function safeDown()
    {
        $this->dropColumn(
            self::TABLE_PRODUCT,
            'shipping'
        );
        $this->dropColumn(
            self::TABLE_SHOP,
            'tax'
        );
    }
}