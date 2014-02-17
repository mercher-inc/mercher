<?php

class m140217_123641_delete_tax extends CDbMigration
{
    // tables
    const TABLE_SHOP = 'shop';

    public function safeUp()
    {
        $this->dropColumn(
            self::TABLE_SHOP,
            'tax'
        );
    }

    public function safeDown()
    {
        $this->addColumn(
            self::TABLE_SHOP,
            'tax',
            'NUMERIC (6, 4) DEFAULT 0'
        );
    }
}