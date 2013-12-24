<?php
/**
 * @var $this Controller
 */

$this->menu = array_merge(
    $this->menu,
    [
        [
            'label' => Yii::t('label', 'products'),
            'url'   => ['products/index', 'shop_id' => $this->shop->id],
            'visible'   => Yii::app()->user->checkAccess(
                AuthManager::PERMISSION_READ_PRODUCT,
                [
                    'shop_id' => $this->shop->id
                ]
            )
        ],
        [
            'label' => Yii::t('label', 'categories'),
            'url'   => ['categories/index', 'shop_id' => $this->shop->id],
            'visible'   => Yii::app()->user->checkAccess(
                AuthManager::PERMISSION_READ_CATEGORY,
                [
                    'shop_id' => $this->shop->id
                ]
            )
        ],
        [
            'label' => Yii::t('label', 'managers'),
            'url'   => ['managers/index', 'shop_id' => $this->shop->id],
            'visible'   => Yii::app()->user->checkAccess(
                AuthManager::PERMISSION_READ_MANAGER,
                [
                    'shop_id' => $this->shop->id
                ]
            )
        ],
        [
            'label' => Yii::t('label', 'design'),
            'url'   => ['design/index', 'shop_id' => $this->shop->id],
            'visible'   => Yii::app()->user->checkAccess(
                AuthManager::PERMISSION_UPDATE_SHOP,
                [
                    'shop_id' => $this->shop->id
                ]
            )
        ],
        [
            'label' => Yii::t('shop', 'edit'),
            'url'   => ['shops/update', 'shop_id' => $this->shop->id],
            'visible'   => Yii::app()->user->checkAccess(
                AuthManager::PERMISSION_UPDATE_SHOP,
                [
                    'shop_id' => $this->shop->id
                ]
            )
        ]
    ]
);

array_push(
    Yii::app()->controller->headerButtons,
    [
        'title'       => Yii::t('shop', 'view_online'),
        'url'         => 'https://www.facebook.com/' . $this->shop->fb_id . '?' . http_build_query(
            [
                'sk' => 'app_' . Yii::app()->facebook->sdk->getAppId()
            ]
        ),
        'htmlOptions' => [
            'target' => '_blank'
        ]
    ]
);

$this->beginContent('//layouts/default');
echo $content;
$this->endContent();