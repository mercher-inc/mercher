<?php

class m140217_124732_product_price extends CDbMigration
{
    // tables
    const TABLE_PRODUCT = 'product';

    public function safeUp()
    {
        $this->renameColumn(
            self::TABLE_PRODUCT,
            'amount',
            'price'
        );
    }

    public function safeDown()
    {
        $this->renameColumn(
            self::TABLE_PRODUCT,
            'price',
            'amount'
        );
    }
}