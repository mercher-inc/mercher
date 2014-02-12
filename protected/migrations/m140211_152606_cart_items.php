<?php

class m140211_152606_cart_items extends CDbMigration
{
    // tables
    const TABLE_OBJECT    = 'object';
    const TABLE_USER      = 'user';
    const TABLE_PRODUCT   = 'product';
    const TABLE_CART_ITEM = 'cart_item';
    // prefixes
    const PREFIX_PRIMARY_KEY  = 'pk_';
    const PREFIX_FOREIGN_KEY  = 'fk_';
    const PREFIX_UNIQUE_INDEX = 'ui_';

    public function safeUp()
    {
        /*
         * TABLE_CART_ITEM
         */
        $this->createTable(
            self::TABLE_CART_ITEM,
            array(
                'user_id'    => 'bigint NOT NULL',
                'product_id' => 'bigint NOT NULL',
                'amount'     => 'integer NOT NULL',
            ),
            'INHERITS (' . self::TABLE_OBJECT . ')'
        );
        $this->addPrimaryKey(
            self::PREFIX_PRIMARY_KEY . self::TABLE_CART_ITEM,
            self::TABLE_CART_ITEM,
            'id'
        );
        $this->createIndex(
            self::PREFIX_UNIQUE_INDEX . self::TABLE_CART_ITEM . '_user_id_product_id',
            self::TABLE_CART_ITEM,
            'user_id, product_id',
            true
        );
        $this->addForeignKey(
            self::PREFIX_FOREIGN_KEY . self::TABLE_CART_ITEM . '_user_id',
            self::TABLE_CART_ITEM,
            'user_id',
            self::TABLE_USER,
            'id',
            'CASCADE',
            'CASCADE'
        );
        $this->addForeignKey(
            self::PREFIX_FOREIGN_KEY . self::TABLE_CART_ITEM . '_product_id',
            self::TABLE_CART_ITEM,
            'product_id',
            self::TABLE_PRODUCT,
            'id',
            'CASCADE',
            'CASCADE'
        );
    }

    public function safeDown()
    {
        /*
         * TABLE_CART_ITEM
         */
        $this->dropForeignKey(
            self::PREFIX_FOREIGN_KEY . self::TABLE_CART_ITEM . '_product_id',
            self::TABLE_CART_ITEM
        );
        $this->dropForeignKey(
            self::PREFIX_FOREIGN_KEY . self::TABLE_CART_ITEM . '_user_id',
            self::TABLE_CART_ITEM
        );
        $this->dropTable(
            self::TABLE_CART_ITEM
        );
    }

}