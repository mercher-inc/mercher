<?php

class m140212_160803_orders extends CDbMigration
{
    // tables
    const TABLE_OBJECT     = 'object';
    const TABLE_USER       = 'user';
    const TABLE_SHOP       = 'shop';
    const TABLE_PRODUCT    = 'product';
    const TABLE_ORDER      = 'order';
    const TABLE_ORDER_ITEM = 'order_item';
    // prefixes
    const PREFIX_PRIMARY_KEY = 'pk_';
    const PREFIX_FOREIGN_KEY = 'fk_';
    // types
    const TYPE_ORDER_STATUS = 't_order_status';

    public $orderStatuses = [
        'new',
        'waiting_for_payment',
        'accepted',
        'rejected',
        'approved',
        'completed',
    ];

    public function safeUp()
    {
        /*
         * TYPE_ORDER_STATUS
         */
        $this->execute(
            'CREATE TYPE ' . self::TYPE_ORDER_STATUS . ' AS ENUM (\'' . implode('\',\'', $this->orderStatuses) . '\');'
        );

        /*
         * TABLE_ORDER
         */
        $this->createTable(
            self::TABLE_ORDER,
            array(
                'shop_id' => 'bigint NOT NULL',
                'user_id' => 'bigint NOT NULL',
                'pay_key' => 'varchar(50) NULL',
                'status'  => self::TYPE_ORDER_STATUS,
            ),
            'INHERITS (' . self::TABLE_OBJECT . ')'
        );
        $this->addPrimaryKey(
            self::PREFIX_PRIMARY_KEY . self::TABLE_ORDER,
            self::TABLE_ORDER,
            'id'
        );
        $this->addForeignKey(
            self::PREFIX_FOREIGN_KEY . self::TABLE_ORDER . '_user_id',
            self::TABLE_ORDER,
            'user_id',
            self::TABLE_USER,
            'id',
            'RESTRICT',
            'CASCADE'
        );
        $this->addForeignKey(
            self::PREFIX_FOREIGN_KEY . self::TABLE_ORDER . '_shop_id',
            self::TABLE_ORDER,
            'shop_id',
            self::TABLE_SHOP,
            'id',
            'RESTRICT',
            'CASCADE'
        );

        /*
         * TABLE_ORDER_ITEM
         */
        $this->createTable(
            self::TABLE_ORDER_ITEM,
            array(
                'order_id'   => 'bigint NOT NULL',
                'product_id' => 'bigint NOT NULL',
                'price'      => 'NUMERIC (9, 2) DEFAULT NULL',
                'amount'     => 'integer NOT NULL',
            ),
            'INHERITS (' . self::TABLE_OBJECT . ')'
        );
        $this->addPrimaryKey(
            self::PREFIX_PRIMARY_KEY . self::TABLE_ORDER_ITEM,
            self::TABLE_ORDER_ITEM,
            'id'
        );
        $this->addForeignKey(
            self::PREFIX_FOREIGN_KEY . self::TABLE_ORDER_ITEM . '_order_id',
            self::TABLE_ORDER_ITEM,
            'order_id',
            self::TABLE_ORDER,
            'id',
            'CASCADE',
            'CASCADE'
        );
        $this->addForeignKey(
            self::PREFIX_FOREIGN_KEY . self::TABLE_ORDER_ITEM . '_product_id',
            self::TABLE_ORDER_ITEM,
            'product_id',
            self::TABLE_PRODUCT,
            'id',
            'RESTRICT',
            'CASCADE'
        );
    }

    public function safeDown()
    {
        /*
         * TABLE_ORDER_ITEM
         */
        $this->dropForeignKey(
            self::PREFIX_FOREIGN_KEY . self::TABLE_ORDER_ITEM . '_product_id',
            self::TABLE_ORDER_ITEM
        );
        $this->dropForeignKey(
            self::PREFIX_FOREIGN_KEY . self::TABLE_ORDER_ITEM . '_order_id',
            self::TABLE_ORDER_ITEM
        );
        $this->dropTable(
            self::TABLE_ORDER_ITEM
        );

        /*
         * TABLE_ORDER
         */
        $this->dropForeignKey(
            self::PREFIX_FOREIGN_KEY . self::TABLE_ORDER . '_shop_id',
            self::TABLE_ORDER
        );
        $this->dropForeignKey(
            self::PREFIX_FOREIGN_KEY . self::TABLE_ORDER . '_user_id',
            self::TABLE_ORDER
        );
        $this->dropTable(
            self::TABLE_ORDER
        );

        /*
         * TYPE_ORDER_STATUS
         */
        $this->execute('DROP TYPE ' . self::TYPE_ORDER_STATUS);
    }
}