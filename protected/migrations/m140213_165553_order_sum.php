<?php

class m140213_165553_order_sum extends CDbMigration
{
    // tables
    const TABLE_ORDER      = 'order';

	public function safeUp()
	{
        $this->addColumn(
            self::TABLE_ORDER,
            'total',
            'NUMERIC (9, 2) DEFAULT NULL'
        );

        $orders = Order::model()->findAll();

        foreach ($orders as $order) {
            $order->updateTotal();
        }
	}

	public function safeDown()
	{
        $this->dropColumn(
            self::TABLE_ORDER,
            'total'
        );
	}
}