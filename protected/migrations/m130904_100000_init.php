<?php

class m130904_100000_init extends CDbMigration
{
    public function safeUp()
    {
        /*
         * images table
         */
        $this->createTable(
            'images',
            array(
                'id'        => 'bigserial PRIMARY KEY',
                'file_name' => 'varchar(250) NOT NULL',
                'ext'       => 'varchar(5) NULL',
                'dir'       => 'varchar(250) NULL',
                'created'   => 'timestamp NOT NULL',
                'updated'   => 'timestamp DEFAULT NULL',
                'deleted'   => 'timestamp DEFAULT NULL',
                'revision'  => 'varchar(50) NOT NULL',
            )
        );

        /*
         * users table
         */
        $this->createTable(
            'users',
            array(
                'id'         => 'bigint PRIMARY KEY',
                'email'      => 'varchar(250) NOT NULL',
                'first_name' => 'varchar(50) NULL',
                'last_name'  => 'varchar(50) NULL',
                'banned'     => 'timestamp NULL',
                'last_login' => 'timestamp NULL',
                'created'    => 'timestamp NOT NULL',
                'updated'    => 'timestamp NULL',
                'deleted'    => 'timestamp NULL',
                'revision'   => 'varchar(50) NULL',
            )
        );

        /*
         * shops table
         */
        $this->createTable(
            'shops',
            array(
                'id'          => 'bigserial PRIMARY KEY',
                'owner_id'    => 'bigint NOT NULL',
                'title'       => 'varchar(50) NULL',
                'description' => 'text',
                'banned'      => 'timestamp NULL',
                'created'     => 'timestamp NOT NULL',
                'updated'     => 'timestamp NULL',
                'deleted'     => 'timestamp NULL',
                'revision'    => 'varchar(50) NULL',
            )
        );
        $this->addForeignKey('shops_owner_id_FK', 'shops', 'owner_id', 'users', 'id', 'RESTRICT', 'CASCADE');

        /*
         * categories table
         */
        $this->createTable(
            'categories',
            array(
                'id'          => 'bigserial PRIMARY KEY',
                'shop_id'     => 'bigint NOT NULL',
                'title'       => 'varchar(50) NOT NULL',
                'description' => 'text',
                'created'     => 'timestamp NOT NULL',
                'updated'     => 'timestamp NULL',
                'deleted'     => 'timestamp NULL',
                'revision'    => 'varchar(50) NULL',
            )
        );
        $this->addForeignKey('categories_shop_id_FK', 'categories', 'shop_id', 'shops', 'id', 'RESTRICT', 'CASCADE');

        /*
         * tabs table
         */
        $this->createTable(
            'tabs',
            array(
                'id'       => 'bigint PRIMARY KEY',
                'shop_id'  => 'bigint NOT NULL',
                'banned'   => 'timestamp NULL',
                'created'  => 'timestamp NOT NULL',
                'updated'  => 'timestamp NULL',
                'deleted'  => 'timestamp NULL',
                'revision' => 'varchar(50) NULL',
            )
        );
        $this->addForeignKey('tabs_shop_id_FK', 'tabs', 'shop_id', 'shops', 'id', 'RESTRICT', 'CASCADE');

        /*
         * products table
         */
        $this->createTable(
            'products',
            array(
                'id'           => 'bigint PRIMARY KEY',
                'shop_id'      => 'bigint NOT NULL',
                'category_id'  => 'bigint NULL',
                'title'        => 'varchar(50) NULL',
                'plural_title' => 'varchar(50) NULL',
                'brand'        => 'varchar(50) NULL',
                'description'  => 'text',
                'image_id'     => 'bigint NULL',
                'price'        => 'money NULL',
                'banned'       => 'timestamp NULL',
                'created'      => 'timestamp NOT NULL',
                'updated'      => 'timestamp NULL',
                'deleted'      => 'timestamp NULL',
                'revision'     => 'varchar(50) NULL',
            )
        );
        $this->addForeignKey('products_shop_id_FK', 'products', 'shop_id', 'shops', 'id', 'RESTRICT', 'CASCADE');
        $this->addForeignKey('products_category_id_FK', 'products', 'category_id', 'categories', 'id', 'SET NULL', 'CASCADE');
        $this->addForeignKey('products_image_id_FK', 'products', 'image_id', 'images', 'id', 'SET NULL', 'CASCADE');
    }

    public function safeDown()
    {
        $this->dropForeignKey('products_image_id_FK', 'products');
        $this->dropForeignKey('products_category_id_FK', 'products');
        $this->dropForeignKey('products_shop_id_FK', 'products');
        $this->dropTable('products');

        $this->dropForeignKey('tabs_shop_id_FK', 'tabs');
        $this->dropTable('tabs');

        $this->dropForeignKey('categories_shop_id_FK', 'categories');
        $this->dropTable('categories');

        $this->dropForeignKey('shops_owner_id_FK', 'shops');
        $this->dropTable('shops');

        $this->dropTable('users');

        $this->dropTable('images');
    }
}