<?php

class m131114_172922_ga extends CDbMigration
{
    // tables
    const TABLE_SHOP = 'shop';

    public function safeUp()
    {
        /*
         * TABLE_SHOP
         */
        $this->addColumn(
            self::TABLE_SHOP,
            'ga_id',
            'varchar(50)'
        );
    }

    public function safeDown()
    {
        /*
         * TABLE_SHOP
         */
        $this->dropColumn(
            self::TABLE_SHOP,
            'ga_id'
        );
    }
}