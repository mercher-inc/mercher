<?php
/**
 * Project: mercher
 * Author: Dmitry Les
 * Date: 12/23/13
 * Time: 5:31 PM
 */

class AuthManager extends CPhpAuthManager
{
    //ROLES
    const ROLE_OWNER              = 'roleOwner';
    const ROLE_SHOP_MANAGER       = 'roleShopManager';
    const ROLE_PRODUCTS_MANAGER   = 'roleProductsManager';
    const ROLE_CATEGORIES_MANAGER = 'roleCategoriesManager';

    //SHOP
    const PERMISSION_CREATE_SHOP = 'permissionCreateShop';
    const PERMISSION_READ_SHOP   = 'permissionReadShop';
    const PERMISSION_UPDATE_SHOP = 'permissionUpdateShop';
    const PERMISSION_DELETE_SHOP = 'permissionDeleteShop';

    //MANAGER
    const PERMISSION_CREATE_MANAGER = 'permissionCreateManager';
    const PERMISSION_READ_MANAGER   = 'permissionReadManager';
    const PERMISSION_UPDATE_MANAGER = 'permissionUpdateManager';
    const PERMISSION_DELETE_MANAGER = 'permissionDeleteManager';

    //PRODUCT
    const PERMISSION_CREATE_PRODUCT = 'permissionCreateProduct';
    const PERMISSION_READ_PRODUCT   = 'permissionReadProduct';
    const PERMISSION_UPDATE_PRODUCT = 'permissionUpdateProduct';
    const PERMISSION_DELETE_PRODUCT = 'permissionDeleteProduct';

    //CATEGORY
    const PERMISSION_CREATE_CATEGORY = 'permissionCreateCategory';
    const PERMISSION_READ_CATEGORY   = 'permissionReadCategory';
    const PERMISSION_UPDATE_CATEGORY = 'permissionUpdateCategory';
    const PERMISSION_DELETE_CATEGORY = 'permissionDeleteCategory';

    public $defaultRoles = [
        self::ROLE_OWNER,
        self::ROLE_SHOP_MANAGER,
        self::ROLE_PRODUCTS_MANAGER,
        self::ROLE_CATEGORIES_MANAGER
    ];

    public function init()
    {
        parent::init();

        //Build ACL if it wasn't cached before
        if (!file_exists($this->authFile)) {
            $this->build();
            $this->save();
        }
    }

    public function executeBizRule($bizRule, $params, $data)
    {
        //Callbacks in bizRule
        if (is_callable($bizRule, true)) {
            return call_user_func($bizRule, $params, $data);
        } else {
            return parent::executeBizRule($bizRule, $params, $data);
        }
    }

    public function build()
    {
        $this->clearAll();

        //SHOP
        $this->createOperation(
            self::PERMISSION_CREATE_SHOP,
            null,
            [__CLASS__, 'checkPermissionCreateShop']
        );
        $this->createOperation(
            self::PERMISSION_READ_SHOP,
            null,
            [__CLASS__, 'checkPermissionReadShop']
        );
        $this->createOperation(
            self::PERMISSION_UPDATE_SHOP,
            null,
            [__CLASS__, 'checkPermissionUpdateShop']
        );
        $this->createOperation(
            self::PERMISSION_DELETE_SHOP,
            null,
            [__CLASS__, 'checkPermissionDeleteShop']
        );

        //MANAGER
        $this->createOperation(
            self::PERMISSION_CREATE_MANAGER,
            null,
            [__CLASS__, 'checkPermissionCreateManager']
        );
        $this->createOperation(
            self::PERMISSION_READ_MANAGER,
            null,
            [__CLASS__, 'checkPermissionReadManager']
        );
        $this->createOperation(
            self::PERMISSION_UPDATE_MANAGER,
            null,
            [__CLASS__, 'checkPermissionUpdateManager']
        );
        $this->createOperation(
            self::PERMISSION_DELETE_MANAGER,
            null,
            [__CLASS__, 'checkPermissionDeleteManager']
        );

        //PRODUCT
        $this->createOperation(
            self::PERMISSION_CREATE_PRODUCT,
            null,
            [__CLASS__, 'checkPermissionCreateProduct']
        );
        $this->createOperation(
            self::PERMISSION_READ_PRODUCT,
            null,
            [__CLASS__, 'checkPermissionReadProduct']
        );
        $this->createOperation(
            self::PERMISSION_UPDATE_PRODUCT,
            null,
            [__CLASS__, 'checkPermissionUpdateProduct']
        );
        $this->createOperation(
            self::PERMISSION_DELETE_PRODUCT,
            null,
            [__CLASS__, 'checkPermissionDeleteProduct']
        );

        //CATEGORY
        $this->createOperation(
            self::PERMISSION_CREATE_CATEGORY,
            null,
            [__CLASS__, 'checkPermissionCreateCategory']
        );
        $this->createOperation(
            self::PERMISSION_READ_CATEGORY,
            null,
            [__CLASS__, 'checkPermissionReadCategory']
        );
        $this->createOperation(
            self::PERMISSION_UPDATE_CATEGORY,
            null,
            [__CLASS__, 'checkPermissionUpdateCategory']
        );
        $this->createOperation(
            self::PERMISSION_DELETE_CATEGORY,
            null,
            [__CLASS__, 'checkPermissionDeleteCategory']
        );

        $roleOwner = $this->createRole(
            self::ROLE_OWNER,
            null,
            [__CLASS__, 'checkRoleOwner']
        );
        $roleOwner->addChild(self::PERMISSION_CREATE_SHOP);
        $roleOwner->addChild(self::PERMISSION_READ_SHOP);
        $roleOwner->addChild(self::PERMISSION_UPDATE_SHOP);
        $roleOwner->addChild(self::PERMISSION_DELETE_SHOP);
        $roleOwner->addChild(self::PERMISSION_CREATE_MANAGER);
        $roleOwner->addChild(self::PERMISSION_READ_MANAGER);
        $roleOwner->addChild(self::PERMISSION_UPDATE_MANAGER);
        $roleOwner->addChild(self::PERMISSION_DELETE_MANAGER);
        $roleOwner->addChild(self::PERMISSION_CREATE_PRODUCT);
        $roleOwner->addChild(self::PERMISSION_READ_PRODUCT);
        $roleOwner->addChild(self::PERMISSION_UPDATE_PRODUCT);
        $roleOwner->addChild(self::PERMISSION_DELETE_PRODUCT);
        $roleOwner->addChild(self::PERMISSION_CREATE_CATEGORY);
        $roleOwner->addChild(self::PERMISSION_READ_CATEGORY);
        $roleOwner->addChild(self::PERMISSION_UPDATE_CATEGORY);
        $roleOwner->addChild(self::PERMISSION_DELETE_CATEGORY);

        $roleShopManager = $this->createRole(
            self::ROLE_SHOP_MANAGER,
            null,
            [__CLASS__, 'checkRoleShopManager']
        );
        $roleShopManager->addChild(self::PERMISSION_READ_SHOP);
        $roleShopManager->addChild(self::PERMISSION_READ_PRODUCT);
        $roleShopManager->addChild(self::PERMISSION_READ_CATEGORY);
        $roleShopManager->addChild(self::PERMISSION_UPDATE_SHOP);

        $roleProductsManager = $this->createRole(
            self::ROLE_PRODUCTS_MANAGER,
            null,
            [__CLASS__, 'checkRoleProductsManager']
        );
        $roleProductsManager->addChild(self::PERMISSION_READ_SHOP);
        $roleProductsManager->addChild(self::PERMISSION_READ_PRODUCT);
        $roleProductsManager->addChild(self::PERMISSION_READ_CATEGORY);
        $roleProductsManager->addChild(self::PERMISSION_CREATE_PRODUCT);
        $roleProductsManager->addChild(self::PERMISSION_UPDATE_PRODUCT);
        $roleProductsManager->addChild(self::PERMISSION_DELETE_PRODUCT);

        $roleCategoriesManager = $this->createRole(
            self::ROLE_CATEGORIES_MANAGER,
            null,
            [__CLASS__, 'checkRoleCategoriesManager']
        );
        $roleCategoriesManager->addChild(self::PERMISSION_READ_SHOP);
        $roleCategoriesManager->addChild(self::PERMISSION_READ_PRODUCT);
        $roleCategoriesManager->addChild(self::PERMISSION_READ_CATEGORY);
        $roleCategoriesManager->addChild(self::PERMISSION_CREATE_CATEGORY);
        $roleCategoriesManager->addChild(self::PERMISSION_UPDATE_CATEGORY);
        $roleCategoriesManager->addChild(self::PERMISSION_DELETE_CATEGORY);
    }

    protected function getShopByProduct($productId)
    {
        return Yii::app()->db->createCommand()
            ->select("shop_id")
            ->from(Product::model()->tableName())
            ->where(
                "id = :productId",
                [
                    ":productId" => (int)$productId
                ]
            )
            ->queryScalar();
    }

    protected function getShopByCategory($categoryId)
    {
        return Yii::app()->db->createCommand()
            ->select("shop_id")
            ->from(Category::model()->tableName())
            ->where(
                "id = :categoryId",
                [
                    ":categoryId" => (int)$categoryId
                ]
            )
            ->queryScalar();
    }

    protected function getShopByParams(array $params)
    {
        if (isset($params['shop_id'])) {
            return $params['shop_id'];
        } elseif (isset($params['product_id'])) {
            return $this->getShopByProduct($params['product_id']);
        } elseif (isset($params['category_id'])) {
            return $this->getShopByCategory($params['category_id']);
        } else {
            return null;
        }
    }

    protected function checkRoleOwner($params, $data)
    {
        if (!$shopId = $this->getShopByParams($params)) {
            return false;
        }

        return Yii::app()->db->createCommand()
            ->select("COUNT(*) > 0 AS check")
            ->from(Shop::model()->tableName())
            ->where(
                "id = :shopId AND owner_id = :userId",
                [
                    ":shopId" => (int)$shopId,
                    ":userId" => (int)$params['userId'],
                ]
            )
            ->queryScalar();
    }

    protected function checkRoleShopManager($params, $data)
    {
        if (!$shopId = $this->getShopByParams($params)) {
            return false;
        }

        return Yii::app()->db->createCommand()
            ->select("COUNT(*) > 0 AS check")
            ->from(Manager::model()->tableName())
            ->where(
                "shop_id = :shopId AND user_id = :userId",
                [
                    ":shopId" => (int)$shopId,
                    ":userId" => (int)$params['userId'],
                ]
            )
            ->queryScalar();
    }

    protected function checkRoleProductsManager($params, $data)
    {
        if (!$shopId = $this->getShopByParams($params)) {
            return false;
        }

        return Yii::app()->db->createCommand()
            ->select("COUNT(*) > 0 AS check")
            ->from(Manager::model()->tableName())
            ->where(
                "shop_id = :shopId AND user_id = :userId",
                [
                    ":shopId" => (int)$shopId,
                    ":userId" => (int)$params['userId'],
                ]
            )
            ->queryScalar();
    }

    protected function checkRoleCategoriesManager($params, $data)
    {
        if (!$shopId = $this->getShopByParams($params)) {
            return false;
        }

        return Yii::app()->db->createCommand()
            ->select("COUNT(*) > 0 AS check")
            ->from(Manager::model()->tableName())
            ->where(
                "shop_id = :shopId AND user_id = :userId",
                [
                    ":shopId" => (int)$shopId,
                    ":userId" => (int)$params['userId'],
                ]
            )
            ->queryScalar();
    }

    protected function checkPermissionCreateShop($params, $data)
    {
        return true;
    }

    protected function checkPermissionReadShop($params, $data)
    {
        return true;
    }

    protected function checkPermissionUpdateShop($params, $data)
    {
        return true;
    }

    protected function checkPermissionDeleteShop($params, $data)
    {
        return true;
    }

    protected function checkPermissionCreateManager($params, $data)
    {
        return true;
    }

    protected function checkPermissionReadManager($params, $data)
    {
        return true;
    }

    protected function checkPermissionUpdateManager($params, $data)
    {
        return true;
    }

    protected function checkPermissionDeleteManager($params, $data)
    {
        return true;
    }

    protected function checkPermissionCreateProduct($params, $data)
    {
        return true;
    }

    protected function checkPermissionReadProduct($params, $data)
    {
        return true;
    }

    protected function checkPermissionUpdateProduct($params, $data)
    {
        return true;
    }

    protected function checkPermissionDeleteProduct($params, $data)
    {
        return true;
    }

    protected function checkPermissionCreateCategory($params, $data)
    {
        return true;
    }

    protected function checkPermissionReadCategory($params, $data)
    {
        return true;
    }

    protected function checkPermissionUpdateCategory($params, $data)
    {
        return true;
    }

    protected function checkPermissionDeleteCategory($params, $data)
    {
        return true;
    }
}

class AuthManagerException extends CException
{
}