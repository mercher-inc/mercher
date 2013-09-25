<?php

class m130904_100000_init extends CDbMigration
{
    // tables
    const TABLE_OBJECT   = 'object';
    const TABLE_IMAGE    = 'image';
    const TABLE_TEMPLATE = 'template';
    const TABLE_USER     = 'user';
    const TABLE_SHOP     = 'shop';
    const TABLE_CATEGORY = 'category';
    const TABLE_PRODUCT  = 'product';
    // prefixes
    const PREFIX_PRIMARY_KEY  = 'pk_';
    const PREFIX_FOREIGN_KEY  = 'fk_';
    const PREFIX_INDEX        = 'i_';
    const PREFIX_UNIQUE_INDEX = 'ui_';
    const PREFIX_SEQUENCE     = 's_';
    const PREFIX_TYPE         = 't_';
    const PREFIX_TRIGGER      = 'tr_';
    const PREFIX_FUNCTION     = 'f_';
    // sequences
    const SEQUENCE_GLOBAL_ID = 's_global_id';

    public function safeUp()
    {
        $this->execute('CREATE SEQUENCE ' . self::SEQUENCE_GLOBAL_ID);

        /*
         * TABLE_OBJECT
         */
        $this->createTable(
            self::TABLE_OBJECT,
            array(
                'id'      => 'bigint PRIMARY KEY DEFAULT nextval(\'' . self::SEQUENCE_GLOBAL_ID . '\')',
                'created' => 'timestamp NOT NULL DEFAULT NOW()',
                'updated' => 'timestamp NULL',
            )
        );

        /*
         * TABLE_IMAGE
         */
        $this->createTable(
            self::TABLE_IMAGE,
            array(
                'original_file' => 'varchar(250) NOT NULL',
                'data'          => 'text',
            ),
            'INHERITS (' . self::TABLE_OBJECT . ')'
        );
        $this->addPrimaryKey(
            self::PREFIX_PRIMARY_KEY . self::TABLE_IMAGE,
            self::TABLE_IMAGE,
            'id'
        );

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
         * TABLE_USER
         */
        $this->createTable(
            self::TABLE_USER,
            array(
                'fb_id'      => 'bigint NOT NULL',
                'email'      => 'varchar(250) NOT NULL',
                'first_name' => 'varchar(50) NULL',
                'last_name'  => 'varchar(50) NULL',
                'is_banned'  => 'boolean NOT NULL DEFAULT FALSE',
                'last_login' => 'timestamp NULL',
            ),
            'INHERITS (' . self::TABLE_OBJECT . ')'
        );
        $this->addPrimaryKey(
            self::PREFIX_PRIMARY_KEY . self::TABLE_USER,
            self::TABLE_USER,
            'id'
        );
        $this->createIndex(
            self::PREFIX_UNIQUE_INDEX . 'fb_id_' . self::TABLE_USER,
            self::TABLE_USER,
            'fb_id',
            true
        );

        /*
         * TABLE_SHOP
         */
        $this->createTable(
            self::TABLE_SHOP,
            array(
                'fb_id'           => 'bigint NULL',
                'owner_id'        => 'bigint NOT NULL',
                'title'           => 'varchar(50) NOT NULL',
                'description'     => 'text',
                'template_alias'  => 'varchar(50) NULL',
                'template_config' => 'text',
                'is_active'       => 'boolean NOT NULL DEFAULT TRUE',
                'is_banned'       => 'boolean NOT NULL DEFAULT FALSE',
            ),
            'INHERITS (' . self::TABLE_OBJECT . ')'
        );
        $this->addPrimaryKey(
            self::PREFIX_PRIMARY_KEY . self::TABLE_SHOP,
            self::TABLE_SHOP,
            'id'
        );
        $this->createIndex(
            self::PREFIX_UNIQUE_INDEX . 'fb_id_' . self::TABLE_SHOP,
            self::TABLE_SHOP,
            'fb_id',
            true
        );
        $this->addForeignKey(
            self::PREFIX_FOREIGN_KEY . self::TABLE_SHOP . '_owner_id',
            self::TABLE_SHOP,
            'owner_id',
            self::TABLE_USER,
            'id',
            'CASCADE',
            'CASCADE'
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

        /*
         * TABLE_CATEGORY
         */
        $this->createTable(
            self::TABLE_CATEGORY,
            array(
                'shop_id'     => 'bigint NOT NULL',
                'title'       => 'varchar(50) NOT NULL',
                'description' => 'text',
                'is_active'   => 'boolean NOT NULL DEFAULT TRUE',
                'is_banned'   => 'boolean NOT NULL DEFAULT FALSE',
            ),
            'INHERITS (' . self::TABLE_OBJECT . ')'
        );
        $this->addPrimaryKey(
            self::PREFIX_PRIMARY_KEY . self::TABLE_CATEGORY,
            self::TABLE_CATEGORY,
            'id'
        );
        $this->addForeignKey(
            self::PREFIX_FOREIGN_KEY . self::TABLE_CATEGORY . '_shop_id',
            self::TABLE_CATEGORY,
            'shop_id',
            self::TABLE_SHOP,
            'id',
            'CASCADE',
            'CASCADE'
        );

        /*
         * TABLE_PRODUCT
         */
        $this->createTable(
            self::TABLE_PRODUCT,
            array(
                'fb_id'       => 'bigint NULL',
                'shop_id'     => 'bigint NOT NULL',
                'category_id' => 'bigint NULL',
                'title'       => 'varchar(50) NOT NULL',
                'description' => 'text',
                'image_id'    => 'bigint NULL',
                'price'       => 'money NULL',
                'is_active'   => 'boolean NOT NULL DEFAULT TRUE',
                'is_banned'   => 'boolean NOT NULL DEFAULT FALSE',
            ),
            'INHERITS (' . self::TABLE_OBJECT . ')'
        );
        $this->addPrimaryKey(
            self::PREFIX_PRIMARY_KEY . self::TABLE_PRODUCT,
            self::TABLE_PRODUCT,
            'id'
        );
        $this->createIndex(
            self::PREFIX_UNIQUE_INDEX . 'fb_id_' . self::TABLE_PRODUCT,
            self::TABLE_PRODUCT,
            'fb_id',
            true
        );
        $this->addForeignKey(
            self::PREFIX_FOREIGN_KEY . self::TABLE_PRODUCT . '_shop_id',
            self::TABLE_PRODUCT,
            'shop_id',
            self::TABLE_SHOP,
            'id',
            'CASCADE',
            'CASCADE'
        );
        $this->addForeignKey(
            self::PREFIX_FOREIGN_KEY . self::TABLE_PRODUCT . '_category_id',
            self::TABLE_PRODUCT,
            'category_id',
            self::TABLE_CATEGORY,
            'id',
            'SET NULL',
            'CASCADE'
        );
        $this->addForeignKey(
            self::PREFIX_FOREIGN_KEY . self::TABLE_PRODUCT . '_image_id',
            self::TABLE_PRODUCT,
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
         * TABLE_PRODUCT
         */
        $this->dropForeignKey(
            self::PREFIX_FOREIGN_KEY . self::TABLE_PRODUCT . '_image_id',
            self::TABLE_PRODUCT
        );
        $this->dropForeignKey(
            self::PREFIX_FOREIGN_KEY . self::TABLE_PRODUCT . '_category_id',
            self::TABLE_PRODUCT
        );
        $this->dropForeignKey(
            self::PREFIX_FOREIGN_KEY . self::TABLE_PRODUCT . '_shop_id',
            self::TABLE_PRODUCT
        );
        $this->dropTable(self::TABLE_PRODUCT);

        /*
         * TABLE_CATEGORY
         */
        $this->dropForeignKey(
            self::PREFIX_FOREIGN_KEY . self::TABLE_CATEGORY . '_shop_id',
            self::TABLE_CATEGORY
        );
        $this->dropTable(self::TABLE_CATEGORY);

        /*
         * TABLE_SHOP
         */
        $this->dropForeignKey(
            self::PREFIX_FOREIGN_KEY . self::TABLE_SHOP . '_template_alias',
            self::TABLE_SHOP
        );
        $this->dropForeignKey(
            self::PREFIX_FOREIGN_KEY . self::TABLE_SHOP . '_owner_id',
            self::TABLE_SHOP
        );
        $this->dropTable(self::TABLE_SHOP);

        /*
         * TABLE_USER
         */
        $this->dropTable(self::TABLE_USER);

        /*
         * TABLE_TEMPLATE
         */
        $this->dropTable(self::TABLE_TEMPLATE);

        /*
         * TABLE_IMAGE
         */
        $this->dropTable(self::TABLE_IMAGE);

        /*
         * TABLE_OBJECT
         */
        $this->dropTable(self::TABLE_OBJECT);

        $this->execute('DROP SEQUENCE ' . self::SEQUENCE_GLOBAL_ID);
    }
}