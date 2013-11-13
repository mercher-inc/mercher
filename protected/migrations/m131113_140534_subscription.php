<?php

class m131113_140534_subscription extends CDbMigration
{
    // tables
    const TABLE_OBJECT       = 'object';
    const TABLE_SUBSCRIPTION = 'subscription';
    // prefixes
    const PREFIX_PRIMARY_KEY = 'pk_';
    const PREFIX_FOREIGN_KEY = 'fk_';

    public function safeUp()
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
                'products_count' => 'integer NOT NULL DEFAULT 10'
            ),
            'INHERITS (' . self::TABLE_OBJECT . ')'
        );
        $this->addPrimaryKey(
            self::PREFIX_PRIMARY_KEY . self::TABLE_SUBSCRIPTION,
            self::TABLE_SUBSCRIPTION,
            'id'
        );
    }

    public function safeDown()
    {
        /*
         * TABLE_SUBSCRIPTION
         */
        $this->dropTable(self::TABLE_SUBSCRIPTION);
    }
}