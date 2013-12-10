<?php

class m131210_145544_shop_image extends CDbMigration
{
    // tables
    const TABLE_IMAGE    = 'image';
    const TABLE_SHOP = 'shop';
    // prefixes
    const PREFIX_FOREIGN_KEY  = 'fk_';

    public function safeUp()
    {
        /*
         * TABLE_SHOP
         */
        $this->addColumn(
            self::TABLE_SHOP,
            'image_id',
            'bigint NULL'
        );
        $this->addForeignKey(
            self::PREFIX_FOREIGN_KEY . self::TABLE_SHOP . '_image_id',
            self::TABLE_SHOP,
            'image_id',
            self::TABLE_IMAGE,
            'id',
            'SET NULL',
            'CASCADE'
        );
    }

    public function safeDown()
    {
        /*
         * TABLE_SHOP
         */
        $this->dropForeignKey(
            self::PREFIX_FOREIGN_KEY . self::TABLE_SHOP . '_image_id',
            self::TABLE_SHOP
        );
        $this->dropColumn(
            self::TABLE_SHOP,
            'image_id'
        );
    }
}