<?php

class m140217_123025_delete_template extends CDbMigration
{
    // tables
    const TABLE_OBJECT   = 'object';
    const TABLE_TEMPLATE = 'template';
    const TABLE_SHOP     = 'shop';
    // prefixes
    const PREFIX_PRIMARY_KEY = 'pk_';
    const PREFIX_FOREIGN_KEY = 'fk_';

    public function safeUp()
    {
        /*
         * TABLE_SHOP
         */
        $this->dropForeignKey(
            self::PREFIX_FOREIGN_KEY . self::TABLE_SHOP . '_template_alias',
            self::TABLE_SHOP
        );
        $this->dropColumn(
            self::TABLE_SHOP,
            'template_alias'
        );
        $this->dropColumn(
            self::TABLE_SHOP,
            'template_config'
        );

        /*
         * TABLE_TEMPLATE
         */
        $this->dropTable(
            self::TABLE_TEMPLATE
        );
    }

    public function safeDown()
    {
        /*
         * TABLE_TEMPLATE
         */
        $this->createTable(
            self::TABLE_TEMPLATE,
            array(
                'alias'       => 'varchar(50) NOT NULL',
                'title'       => 'varchar(50) NOT NULL',
                'description' => 'text',
            )
        );
        $this->addPrimaryKey(
            self::PREFIX_PRIMARY_KEY . self::TABLE_TEMPLATE,
            self::TABLE_TEMPLATE,
            'alias'
        );

        /*
         * TABLE_SHOP
         */
        $this->addColumn(
            self::TABLE_SHOP,
            'template_alias',
            'varchar(50) NULL'
        );
        $this->addColumn(
            self::TABLE_SHOP,
            'template_config',
            'text'
        );
        $this->addForeignKey(
            self::PREFIX_FOREIGN_KEY . self::TABLE_SHOP . '_template_alias',
            self::TABLE_SHOP,
            'template_alias',
            self::TABLE_TEMPLATE,
            'alias',
            'SET NULL',
            'CASCADE'
        );
    }
}