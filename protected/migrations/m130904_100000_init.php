<?php

class m130904_100000_init extends CDbMigration
{
    public function safeUp()
    {
        $this->execute('CREATE SEQUENCE s_object_id');

        /*
         * objects table
         */
        $this->createTable(
            'object',
            array(
                'id'      => 'bigint PRIMARY KEY DEFAULT nextval(\'s_object_id\')',
                'created' => 'timestamp NOT NULL DEFAULT NOW()',
                'updated' => 'timestamp DEFAULT NULL',
            )
        );

        /*
         * images table
         */
        $this->createTable(
            'image',
            array(
                'original_file' => 'varchar(250) NOT NULL',
                'data'          => 'text',
            ),
            'INHERITS (object)'
        );
        $this->createIndex(
            'pk_image',
            'image',
            'id',
            true
        );

        /*
         * users table
         */
        $this->createTable(
            'user',
            array(
                'fb_id'      => 'bigint PRIMARY KEY',
                'email'      => 'varchar(250) NOT NULL',
                'first_name' => 'varchar(50) NULL',
                'last_name'  => 'varchar(50) NULL',
                'banned'     => 'timestamp NULL',
                'last_login' => 'timestamp NULL',
            ),
            'INHERITS (object)'
        );
        $this->createIndex(
            'pk_user',
            'user',
            'id',
            true
        );
        $this->createIndex(
            'fb_user',
            'user',
            'fb_id',
            true
        );

        /*
         * shops table
         */
        $this->createTable(
            'shop',
            array(
                'owner_id'    => 'bigint NOT NULL',
                'title'       => 'varchar(50) NULL',
                'description' => 'text',
                'banned'      => 'timestamp NULL',
            ),
            'INHERITS (object)'
        );
        $this->createIndex(
            'pk_shop',
            'shop',
            'id',
            true
        );
        $this->addForeignKey(
            'fk_shop_owner_id',
            'shop',
            'owner_id',
            'user',
            'id',
            'RESTRICT',
            'CASCADE'
        );

        /*
         * categories table
         */
        $this->createTable(
            'category',
            array(
                'shop_id'     => 'bigint NOT NULL',
                'title'       => 'varchar(50) NOT NULL',
                'description' => 'text',
            ),
            'INHERITS (object)'
        );
        $this->createIndex(
            'pk_category',
            'category',
            'id',
            true
        );
        $this->addForeignKey(
            'fk_category_shop_id',
            'category',
            'shop_id',
            'shop',
            'id',
            'RESTRICT',
            'CASCADE'
        );

        /*
         * products table
         */
        $this->createTable(
            'product',
            array(
                'fb_id'        => 'bigint NOT NULL',
                'shop_id'      => 'bigint NOT NULL',
                'category_id'  => 'bigint NULL',
                'title'        => 'varchar(50) NULL',
                'plural_title' => 'varchar(50) NULL',
                'brand'        => 'varchar(50) NULL',
                'description'  => 'text',
                'image_id'     => 'bigint NULL',
                'price'        => 'money NULL',
                'banned'       => 'timestamp NULL',
            ),
            'INHERITS (object)'
        );
        $this->createIndex(
            'pk_product',
            'product',
            'id',
            true
        );
        $this->createIndex(
            'fb_product',
            'product',
            'fb_id',
            true
        );
        $this->addForeignKey(
            'fk_product_shop_id',
            'product',
            'shop_id',
            'shop',
            'id',
            'RESTRICT',
            'CASCADE'
        );
        $this->addForeignKey(
            'fk_product_category_id',
            'product',
            'category_id',
            'category',
            'id',
            'SET NULL',
            'CASCADE'
        );
        $this->addForeignKey(
            'fk_product_image_id',
            'product',
            'image_id',
            'image',
            'id',
            'SET NULL',
            'CASCADE'
        );

        /*
         * showcase table
         */
        $this->createTable(
            'showcase',
            array(
                'fb_id'       => 'bigint PRIMARY KEY',
                'shop_id'     => 'bigint NOT NULL',
                'title'       => 'varchar(50) NULL',
                'description' => 'text',
                'banned'      => 'timestamp NULL',
            ),
            'INHERITS (object)'
        );
        $this->createIndex(
            'pk_showcase',
            'showcase',
            'id',
            true
        );
        $this->createIndex(
            'fb_showcase',
            'showcase',
            'fb_id',
            true
        );
        $this->addForeignKey(
            'fk_showcase_shop_id',
            'showcase',
            'shop_id',
            'shop',
            'id',
            'SET NULL',
            'CASCADE'
        );
    }

    public function safeDown()
    {
        $this->dropForeignKey('fk_showcase_shop_id', 'showcase');
        $this->dropTable('showcase');

        $this->dropForeignKey('fk_product_image_id', 'product');
        $this->dropForeignKey('fk_product_category_id', 'product');
        $this->dropForeignKey('fk_product_shop_id', 'product');
        $this->dropTable('product');

        $this->dropForeignKey('fk_category_shop_id', 'category');
        $this->dropTable('category');

        $this->dropForeignKey('fk_shop_owner_id', 'shop');
        $this->dropTable('shop');

        $this->dropTable('user');

        $this->dropTable('image');

        $this->dropTable('object');

        $this->execute('DROP SEQUENCE s_object_id');
    }
}