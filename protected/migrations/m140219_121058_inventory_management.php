<?php

class m140219_121058_inventory_management extends CDbMigration
{
    // tables
    const TABLE_ORDER      = 'order';

	public function safeUp()
	{
        $this->addColumn(
            self::TABLE_ORDER,
            'expires',
            'timestamp NULL'
        );
	}

	public function safeDown()
	{
        $this->dropColumn(
            self::TABLE_ORDER,
            'expires'
        );
	}
}