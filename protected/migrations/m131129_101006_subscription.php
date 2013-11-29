<?php

class m131129_101006_subscription extends CDbMigration
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
         * TABLE_SUBSCRIPTION
         */
        $this->addColumn(
            self::TABLE_SUBSCRIPTION,
            'is_public',
            'boolean NOT NULL DEFAULT FALSE'
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

    public function safeDown()
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
        $this->dropColumn(
            self::TABLE_SUBSCRIPTION,
            'is_public'
        );

    }
}