<?php

class m140217_122612_delete_subscription extends CDbMigration
{
    // tables
    const TABLE_OBJECT       = 'object';
    const TABLE_SUBSCRIPTION = 'subscription';
    const TABLE_SHOP         = 'shop';
    // prefixes
    const PREFIX_PRIMARY_KEY = 'pk_';
    const PREFIX_FOREIGN_KEY = 'fk_';

    public function safeUp()
    {
        /*
         * TABLE_SHOP
         */
        $this->dropForeignKey(
            self::PREFIX_FOREIGN_KEY . self::TABLE_SHOP . '_subscription_id',
            self::TABLE_SHOP
        );
        $this->dropColumn(
            self::TABLE_SHOP,
            'subscription_id'
        );

        /*
         * TABLE_SUBSCRIPTION
         */
        $this->dropTable(self::TABLE_SUBSCRIPTION);
    }

    public function safeDown()
    {
        /*
         * TABLE_SUBSCRIPTION
         */
        $this->createTable(
            self::TABLE_SUBSCRIPTION,
            array(
                'title'          => 'varchar(250) NOT NULL',
                'description'    => 'text',
                'image'          => 'varchar(250) NOT NULL',
                'price'          => 'NUMERIC (9, 2) NOT NULL',
                'trial_duration' => 'integer NOT NULL DEFAULT 0',
                'products_count' => 'integer NOT NULL DEFAULT 10',
                'is_public'      => 'boolean NOT NULL DEFAULT FALSE'
            ),
            'INHERITS (' . self::TABLE_OBJECT . ')'
        );
        $this->addPrimaryKey(
            self::PREFIX_PRIMARY_KEY . self::TABLE_SUBSCRIPTION,
            self::TABLE_SUBSCRIPTION,
            'id'
        );

        /*
         * TABLE_SHOP
         */
        $this->addColumn(
            self::TABLE_SHOP,
            'subscription_id',
            'bigint'
        );

        $this->addForeignKey(
            self::PREFIX_FOREIGN_KEY . self::TABLE_SHOP . '_subscription_id',
            self::TABLE_SHOP,
            'subscription_id',
            self::TABLE_SUBSCRIPTION,
            'id',
            'RESTRICT',
            'CASCADE'
        );
    }
}