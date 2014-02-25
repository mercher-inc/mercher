<?php
return array (
  'permissionCreateShop' => 
  array (
    'type' => 0,
    'description' => NULL,
    'bizRule' => 
    array (
      0 => 'AuthManager',
      1 => 'checkPermissionCreateShop',
    ),
    'data' => NULL,
  ),
  'permissionReadShop' => 
  array (
    'type' => 0,
    'description' => NULL,
    'bizRule' => 
    array (
      0 => 'AuthManager',
      1 => 'checkPermissionReadShop',
    ),
    'data' => NULL,
  ),
  'permissionUpdateShop' => 
  array (
    'type' => 0,
    'description' => NULL,
    'bizRule' => 
    array (
      0 => 'AuthManager',
      1 => 'checkPermissionUpdateShop',
    ),
    'data' => NULL,
  ),
  'permissionDeleteShop' => 
  array (
    'type' => 0,
    'description' => NULL,
    'bizRule' => 
    array (
      0 => 'AuthManager',
      1 => 'checkPermissionDeleteShop',
    ),
    'data' => NULL,
  ),
  'permissionCreateManager' => 
  array (
    'type' => 0,
    'description' => NULL,
    'bizRule' => 
    array (
      0 => 'AuthManager',
      1 => 'checkPermissionCreateManager',
    ),
    'data' => NULL,
  ),
  'permissionReadManager' => 
  array (
    'type' => 0,
    'description' => NULL,
    'bizRule' => 
    array (
      0 => 'AuthManager',
      1 => 'checkPermissionReadManager',
    ),
    'data' => NULL,
  ),
  'permissionUpdateManager' => 
  array (
    'type' => 0,
    'description' => NULL,
    'bizRule' => 
    array (
      0 => 'AuthManager',
      1 => 'checkPermissionUpdateManager',
    ),
    'data' => NULL,
  ),
  'permissionDeleteManager' => 
  array (
    'type' => 0,
    'description' => NULL,
    'bizRule' => 
    array (
      0 => 'AuthManager',
      1 => 'checkPermissionDeleteManager',
    ),
    'data' => NULL,
  ),
  'permissionCreateProduct' => 
  array (
    'type' => 0,
    'description' => NULL,
    'bizRule' => 
    array (
      0 => 'AuthManager',
      1 => 'checkPermissionCreateProduct',
    ),
    'data' => NULL,
  ),
  'permissionReadProduct' => 
  array (
    'type' => 0,
    'description' => NULL,
    'bizRule' => 
    array (
      0 => 'AuthManager',
      1 => 'checkPermissionReadProduct',
    ),
    'data' => NULL,
  ),
  'permissionUpdateProduct' => 
  array (
    'type' => 0,
    'description' => NULL,
    'bizRule' => 
    array (
      0 => 'AuthManager',
      1 => 'checkPermissionUpdateProduct',
    ),
    'data' => NULL,
  ),
  'permissionDeleteProduct' => 
  array (
    'type' => 0,
    'description' => NULL,
    'bizRule' => 
    array (
      0 => 'AuthManager',
      1 => 'checkPermissionDeleteProduct',
    ),
    'data' => NULL,
  ),
  'permissionCreateCategory' => 
  array (
    'type' => 0,
    'description' => NULL,
    'bizRule' => 
    array (
      0 => 'AuthManager',
      1 => 'checkPermissionCreateCategory',
    ),
    'data' => NULL,
  ),
  'permissionReadCategory' => 
  array (
    'type' => 0,
    'description' => NULL,
    'bizRule' => 
    array (
      0 => 'AuthManager',
      1 => 'checkPermissionReadCategory',
    ),
    'data' => NULL,
  ),
  'permissionUpdateCategory' => 
  array (
    'type' => 0,
    'description' => NULL,
    'bizRule' => 
    array (
      0 => 'AuthManager',
      1 => 'checkPermissionUpdateCategory',
    ),
    'data' => NULL,
  ),
  'permissionDeleteCategory' => 
  array (
    'type' => 0,
    'description' => NULL,
    'bizRule' => 
    array (
      0 => 'AuthManager',
      1 => 'checkPermissionDeleteCategory',
    ),
    'data' => NULL,
  ),
  'permissionCreateOrder' => 
  array (
    'type' => 0,
    'description' => NULL,
    'bizRule' => 
    array (
      0 => 'AuthManager',
      1 => 'checkPermissionCreateOrder',
    ),
    'data' => NULL,
  ),
  'permissionReadOrder' => 
  array (
    'type' => 0,
    'description' => NULL,
    'bizRule' => 
    array (
      0 => 'AuthManager',
      1 => 'checkPermissionReadOrder',
    ),
    'data' => NULL,
  ),
  'permissionUpdateOrder' => 
  array (
    'type' => 0,
    'description' => NULL,
    'bizRule' => 
    array (
      0 => 'AuthManager',
      1 => 'checkPermissionUpdateOrder',
    ),
    'data' => NULL,
  ),
  'permissionDeleteOrder' => 
  array (
    'type' => 0,
    'description' => NULL,
    'bizRule' => 
    array (
      0 => 'AuthManager',
      1 => 'checkPermissionDeleteOrder',
    ),
    'data' => NULL,
  ),
  'roleOwner' => 
  array (
    'type' => 2,
    'description' => NULL,
    'bizRule' => 
    array (
      0 => 'AuthManager',
      1 => 'checkRoleOwner',
    ),
    'data' => NULL,
    'children' => 
    array (
      0 => 'permissionCreateShop',
      1 => 'permissionReadShop',
      2 => 'permissionUpdateShop',
      3 => 'permissionDeleteShop',
      4 => 'permissionCreateManager',
      5 => 'permissionReadManager',
      6 => 'permissionUpdateManager',
      7 => 'permissionDeleteManager',
      8 => 'permissionCreateProduct',
      9 => 'permissionReadProduct',
      10 => 'permissionUpdateProduct',
      11 => 'permissionDeleteProduct',
      12 => 'permissionCreateCategory',
      13 => 'permissionReadCategory',
      14 => 'permissionUpdateCategory',
      15 => 'permissionDeleteCategory',
      16 => 'permissionCreateOrder',
      17 => 'permissionReadOrder',
      18 => 'permissionUpdateOrder',
      19 => 'permissionDeleteOrder',
    ),
  ),
  'roleShopManager' => 
  array (
    'type' => 2,
    'description' => NULL,
    'bizRule' => 
    array (
      0 => 'AuthManager',
      1 => 'checkRoleShopManager',
    ),
    'data' => NULL,
    'children' => 
    array (
      0 => 'permissionReadShop',
      1 => 'permissionUpdateShop',
    ),
  ),
  'roleProductsManager' => 
  array (
    'type' => 2,
    'description' => NULL,
    'bizRule' => 
    array (
      0 => 'AuthManager',
      1 => 'checkRoleProductsManager',
    ),
    'data' => NULL,
    'children' => 
    array (
      0 => 'permissionReadShop',
      1 => 'permissionCreateProduct',
      2 => 'permissionReadProduct',
      3 => 'permissionUpdateProduct',
      4 => 'permissionDeleteProduct',
    ),
  ),
  'roleCategoriesManager' => 
  array (
    'type' => 2,
    'description' => NULL,
    'bizRule' => 
    array (
      0 => 'AuthManager',
      1 => 'checkRoleCategoriesManager',
    ),
    'data' => NULL,
    'children' => 
    array (
      0 => 'permissionReadShop',
      1 => 'permissionCreateCategory',
      2 => 'permissionReadCategory',
      3 => 'permissionUpdateCategory',
      4 => 'permissionDeleteCategory',
    ),
  ),
);
