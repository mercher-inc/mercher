<?php

class m131223_165817_managers extends CDbMigration
{
    // tables
    const TABLE_OBJECT  = 'object';
    const TABLE_USER     = 'user';
    const TABLE_SHOP     = 'shop';
    const TABLE_MANAGER = 'manager';
    // prefixes
    const PREFIX_PRIMARY_KEY = 'pk_';
    const PREFIX_FOREIGN_KEY = 'fk_';
    // types
    const TYPE_MANAGER_ROLE = 't_manager_role';
    // roles
    public $roles = [
        'roleShopManager',
        'roleProductsManager',
        'roleCategoriesManager'
    ];

    public function safeUp()
    {
        /*
         * TYPE_MANAGER_ROLE
         */
        $this->execute(
            'CREATE TYPE ' . self::TYPE_MANAGER_ROLE . ' AS ENUM (\'' . implode('\',\'', $this->roles) . '\');'
        );

        /*
         * TABLE_MANAGER
         */
        $this->createTable(
            self::TABLE_MANAGER,
            array(
                'user_id' => 'bigint NOT NULL',
                'shop_id'    => 'bigint NOT NULL',
                'role'       => self::TYPE_MANAGER_ROLE . '[]'
            )
        );
        $this->addPrimaryKey(
            self::PREFIX_PRIMARY_KEY . self::TABLE_MANAGER,
            self::TABLE_MANAGER,
            'user_id, shop_id'
        );
        $this->addForeignKey(
            self::PREFIX_FOREIGN_KEY . self::TABLE_MANAGER . '_user_id',
            self::TABLE_MANAGER,
            'user_id',
            self::TABLE_USER,
            'id',
            'CASCADE',
            'CASCADE'
        );
        $this->addForeignKey(
            self::PREFIX_FOREIGN_KEY . self::TABLE_MANAGER . '_shop_id',
            self::TABLE_MANAGER,
            'shop_id',
            self::TABLE_SHOP,
            'id',
            'CASCADE',
            'CASCADE'
        );
    }

    public function safeDown()
    {
        /*
         * TABLE_MANAGER
         */
        $this->dropForeignKey(
            self::PREFIX_FOREIGN_KEY . self::TABLE_MANAGER . '_shop_id',
            self::TABLE_MANAGER
        );
        $this->dropForeignKey(
            self::PREFIX_FOREIGN_KEY . self::TABLE_MANAGER . '_user_id',
            self::TABLE_MANAGER
        );
        $this->dropTable(
            self::TABLE_MANAGER
        );

        /*
         * TYPE_MANAGER_ROLE
         */
        $this->execute('DROP TYPE ' . self::TYPE_MANAGER_ROLE);
    }
}