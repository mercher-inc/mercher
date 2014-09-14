<?php

/**
 * This is the model class for table "shop".
 * The followings are the available columns in table 'shop':
 * @property string $id
 * @property string $created
 * @property string $updated
 * @property string $fb_id
 * @property string $owner_id
 * @property string $pp_merchant_id
 * @property string $paypal_scope
 * @property string $paypal_token
 * @property string $paypal_token_secret
 * @property string $ga_id
 * @property string $title
 * @property string $description
 * @property string $tax
 * @property string $image_id
 * @property boolean $is_active
 * @property boolean $is_banned
 * The followings are the available model relations:
 * @property User $owner
 * @property Product[] $products
 * @property Image[] $images
 * @property Category[] $categories
 * @property User[] $managers
 * @property integer $managersCount
 * @property Order[] $orders
 * @property array $paypalPermissions
 */
class Shop extends CActiveRecord
{
    const PAYPAL_PERMISSION_EXPRESS_CHECKOUT                  = 'EXPRESS_CHECKOUT';
    const PAYPAL_PERMISSION_DIRECT_PAYMENT                    = 'DIRECT_PAYMENT';
    const PAYPAL_PERMISSION_SETTLEMENT_CONSOLIDATION          = 'SETTLEMENT_CONSOLIDATION';
    const PAYPAL_PERMISSION_SETTLEMENT_REPORTING              = 'SETTLEMENT_REPORTING';
    const PAYPAL_PERMISSION_AUTH_CAPTURE                      = 'AUTH_CAPTURE';
    const PAYPAL_PERMISSION_MOBILE_CHECKOUT                   = 'MOBILE_CHECKOUT';
    const PAYPAL_PERMISSION_BILLING_AGREEMENT                 = 'BILLING_AGREEMENT';
    const PAYPAL_PERMISSION_REFERENCE_TRANSACTION             = 'REFERENCE_TRANSACTION';
    const PAYPAL_PERMISSION_AIR_TRAVEL                        = 'AIR_TRAVEL';
    const PAYPAL_PERMISSION_MASS_PAY                          = 'MASS_PAY';
    const PAYPAL_PERMISSION_TRANSACTION_DETAILS               = 'TRANSACTION_DETAILS';
    const PAYPAL_PERMISSION_TRANSACTION_SEARCH                = 'TRANSACTION_SEARCH';
    const PAYPAL_PERMISSION_RECURRING_PAYMENTS                = 'RECURRING_PAYMENTS';
    const PAYPAL_PERMISSION_ACCOUNT_BALANCE                   = 'ACCOUNT_BALANCE';
    const PAYPAL_PERMISSION_ENCRYPTED_WEBSITE_PAYMENTS        = 'ENCRYPTED_WEBSITE_PAYMENTS';
    const PAYPAL_PERMISSION_REFUND                            = 'REFUND';
    const PAYPAL_PERMISSION_NON_REFERENCED_CREDIT             = 'NON_REFERENCED_CREDIT';
    const PAYPAL_PERMISSION_BUTTON_MANAGER                    = 'BUTTON_MANAGER';
    const PAYPAL_PERMISSION_MANAGE_PENDING_TRANSACTION_STATUS = 'MANAGE_PENDING_TRANSACTION_STATUS';
    const PAYPAL_PERMISSION_RECURRING_PAYMENT_REPORT          = 'RECURRING_PAYMENT_REPORT';
    const PAYPAL_PERMISSION_EXTENDED_PRO_PROCESSING_REPORT    = 'EXTENDED_PRO_PROCESSING_REPORT';
    const PAYPAL_PERMISSION_EXCEPTION_PROCESSING_REPORT       = 'EXCEPTION_PROCESSING_REPORT';
    const PAYPAL_PERMISSION_ACCOUNT_MANAGEMENT_PERMISSION     = 'ACCOUNT_MANAGEMENT_PERMISSION';
    const PAYPAL_PERMISSION_ACCESS_BASIC_PERSONAL_DATA        = 'ACCESS_BASIC_PERSONAL_DATA';
    const PAYPAL_PERMISSION_ACCESS_ADVANCED_PERSONAL_DATA     = 'ACCESS_ADVANCED_PERSONAL_DATA';
    const PAYPAL_PERMISSION_INVOICING                         = 'INVOICING';

    public static function getPaypalPermissionList()
    {
        return [
            self::PAYPAL_PERMISSION_EXPRESS_CHECKOUT,
            self::PAYPAL_PERMISSION_DIRECT_PAYMENT,
            self::PAYPAL_PERMISSION_SETTLEMENT_CONSOLIDATION,
            self::PAYPAL_PERMISSION_SETTLEMENT_REPORTING,
            self::PAYPAL_PERMISSION_AUTH_CAPTURE,
            self::PAYPAL_PERMISSION_MOBILE_CHECKOUT,
            self::PAYPAL_PERMISSION_BILLING_AGREEMENT,
            self::PAYPAL_PERMISSION_REFERENCE_TRANSACTION,
            self::PAYPAL_PERMISSION_AIR_TRAVEL,
            self::PAYPAL_PERMISSION_MASS_PAY,
            self::PAYPAL_PERMISSION_TRANSACTION_DETAILS,
            self::PAYPAL_PERMISSION_TRANSACTION_SEARCH,
            self::PAYPAL_PERMISSION_RECURRING_PAYMENTS,
            self::PAYPAL_PERMISSION_ACCOUNT_BALANCE,
            self::PAYPAL_PERMISSION_ENCRYPTED_WEBSITE_PAYMENTS,
            self::PAYPAL_PERMISSION_REFUND,
            self::PAYPAL_PERMISSION_NON_REFERENCED_CREDIT,
            self::PAYPAL_PERMISSION_BUTTON_MANAGER,
            self::PAYPAL_PERMISSION_MANAGE_PENDING_TRANSACTION_STATUS,
            self::PAYPAL_PERMISSION_RECURRING_PAYMENT_REPORT,
            self::PAYPAL_PERMISSION_EXTENDED_PRO_PROCESSING_REPORT,
            self::PAYPAL_PERMISSION_EXCEPTION_PROCESSING_REPORT,
            self::PAYPAL_PERMISSION_ACCOUNT_MANAGEMENT_PERMISSION,
            self::PAYPAL_PERMISSION_ACCESS_BASIC_PERSONAL_DATA,
            self::PAYPAL_PERMISSION_ACCESS_ADVANCED_PERSONAL_DATA,
            self::PAYPAL_PERMISSION_INVOICING
        ];
    }

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'shop';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('owner_id', 'setDefaultOwnerId', 'on' => 'insert'),
            array('title', 'default', 'value' => 'Shop'),
            array('description, fb_id, ga_id, image_id', 'default', 'value' => null),
            array('description', 'filter', 'filter' => 'strip_tags'),
            array('tax', 'default', 'value' => 0),
            array('tax', 'numerical', 'max' => 99.9999, 'min' => 0),
            array('is_active, is_banned', 'boolFilter'),
            array('fb_id, owner_id', 'required'),
            array('fb_id', 'in', 'not' => true, 'range' => array('430253050396911')),
            array('pp_merchant_id', 'email'),
            array('paypal_scope', 'checkPaypalScope'),
            array('ga_id', 'match', 'pattern' => '/^UA-\d{1,12}-\d{1,4}/'),
            array('owner_id', 'checkOwnerId', 'on' => 'update, delete'),
            array(
                'fb_id',
                'unique',
                'className'     => 'Shop',
                'attributeName' => 'fb_id',
                'message'       => 'This page already has a shop',
                'on'            => 'insert'
            ),
            array('fb_id', 'checkFbId', 'on' => 'insert'),
            array('title', 'length', 'max' => 50),
            array('is_active', 'checkActiveCount'),
            array('title, description, tax, is_active, ga_id, image_id', 'safe'),
            array('fb_id', 'safe', 'on' => 'insert'),
            array(
                'pp_merchant_id, paypal_scope, paypal_token, paypal_token_secret',
                'unsafe'
            ),
            // The following rule is used by search().
            array(
                'id, created, updated, fb_id, owner_id, title, description, tax, is_active, is_banned, pp_merchant_id, image_id',
                'safe',
                'on' => 'search'
            )
        );
    }

    public function checkPaypalScope()
    {
        foreach ($this->paypalPermissions as $permission) {
            if (!in_array($permission, self::getPaypalPermissionList())) {
                $this->addError('paypalPermissions', Yii::t('model', 'permission_unknown'));
            }
        }
    }

    public function getPaypalPermissions()
    {
        if (!trim($this->paypal_scope, '{}')) {
            return array();
        }
        return explode(',', trim($this->paypal_scope, '{}'));
    }

    public function setPaypalPermissions($paypalPermissions)
    {
        if (!is_array($paypalPermissions)) {
            $paypalPermissions = array();
        }
        $paypalPermissions  = array_unique($paypalPermissions);
        $this->paypal_scope = '{' . implode(',', $paypalPermissions) . '}';
    }

    public function setDefaultOwnerId()
    {
        $this->owner_id = Yii::app()->user->id;
    }

    public function checkOwnerId()
    {
        if (
            Yii::app()->user->id !== 'admin'
            and
            $this->owner_id != Yii::app()->user->id
        ) {
            $this->addError('owner_id', 'You are not owner of this shop');
            return false;
        }
        return true;
    }

    public function checkFbId()
    {
        if ($this->fb_id) {
            try {
                Yii::app()->facebook->sdk->api(
                    '/' . $this->fb_id . '?' . http_build_query(array('fields' => 'id'))
                );
            } catch (FacebookApiException $e) {
                $this->addError('fb_id', Yii::t('shop', 'fb_id_error'));
                return false;
            }
        }
        return true;
    }

    public function boolFilter($field)
    {
        switch ($this->$field) {
            case true:
            case 't':
            case 'true':
            case 'y':
            case 'yes':
            case 'on':
            case '1':
                $this->$field = true;
                break;
            case false:
            case 'f':
            case 'false':
            case 'n':
            case 'no':
            case 'off':
            case '0':
                $this->$field = false;
                break;
            default:
                $this->addError($field, $this->getAttributeLabel($field) . ' could be true of false only');
                return false;
        }
        return false;
    }

    public function checkActiveCount()
    {
        if ($this->is_active && Yii::app()->user->id !== 'admin') {
            if ($this->isNewRecord) {
                $count = (int)Shop::model()->count(
                    'owner_id = :ownerId AND is_active = TRUE',
                    array(
                        'ownerId' => Yii::app()->user->id
                    )
                );
            } else {
                $count = (int)Shop::model()->count(
                    'owner_id = :ownerId AND is_active = TRUE AND id != :shopId',
                    array(
                        'ownerId' => Yii::app()->user->id,
                        'shopId'  => $this->id
                    )
                );
            }
            $count++;
            if ($count > 1) {
                $this->addError('is_active', Yii::t('shop', 'too_many_active'));
                return false;
            }
        }
        return true;
    }

    /**
     * @return array relational rules.
     */
    public function relations()
    {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'owner'           => array(self::BELONGS_TO, 'User', 'owner_id'),
            'products'        => array(self::HAS_MANY, 'Product', 'shop_id'),
            'productsCount'   => array(self::STAT, 'Product', 'shop_id'),
            'images'          => array(self::HAS_MANY, 'Image', 'shop_id'),
            'imagesCount'     => array(self::STAT, 'Image', 'shop_id'),
            'categories'      => array(self::HAS_MANY, 'Category', 'shop_id'),
            'categoriesCount' => array(self::STAT, 'Category', 'shop_id'),
            'managers'        => array(self::MANY_MANY, 'User', 'manager(shop_id, user_id)'),
            'managersCount'   => array(self::STAT, 'User', 'manager(shop_id, user_id)'),
            'image'           => array(self::BELONGS_TO, 'Image', 'image_id'),
            'orders'          => array(self::HAS_MANY, 'Order', 'shop_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id'             => 'ID',
            'created'        => 'Created',
            'updated'        => 'Updated',
            'fb_id'          => 'Facebook page',
            'owner_id'       => 'Owner',
            'title'          => 'Tab name',
            'description'    => 'Description',
            'tax'            => 'Tax percentage',
            'image_id'       => 'Tab image',
            'is_active'      => 'Show tab',
            'is_banned'      => 'Banned',
            'pp_merchant_id' => 'PayPal merchant email',
            'ga_id'          => 'Google Analytics ID',
        );
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * Typical usecase:
     * - Initialize the model fields with values from filter form.
     * - Execute this method to get CActiveDataProvider instance which will filter
     * models according to data in model fields.
     * - Pass data provider to CGridView, CListView or any similar widget.
     * @return CActiveDataProvider the data provider that can return the models
     * based on the search/filter conditions.
     */
    public function search()
    {
        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id, true);
        $criteria->compare('created', $this->created, true);
        $criteria->compare('updated', $this->updated, true);
        $criteria->compare('fb_id', $this->fb_id, true);
        $criteria->compare('owner_id', $this->owner_id, true);
        $criteria->compare('title', $this->title, true);
        $criteria->compare('description', $this->description, true);
        $criteria->compare('tax', $this->tax, true);
        $criteria->compare('image_id', $this->image_id);
        $criteria->compare('is_active', $this->is_active);
        $criteria->compare('is_banned', $this->is_banned);
        $criteria->compare('pp_merchant_id', $this->pp_merchant_id, true);
        $criteria->compare('ga_id', $this->ga_id, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    public function behaviors()
    {
        return array(
            'application.models.behaviors.CreateUpdateTimeActiveRecordBehavior',
            'application.models.behaviors.ShopActiveSyncBehavior',
        );
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Shop the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    protected function afterSave()
    {
        parent::afterSave();

        try {
            $ch = curl_init('http://www.google-analytics.com/collect');
            curl_setopt(
                $ch,
                CURLOPT_POSTFIELDS,
                http_build_query(
                    [
                        'v'   => 1,
                        'tid' => 'UA-23393444-14',
                        'cid' => 555,
                        't'   => 'event',
                        'ec'  => 'shop',
                        'ea'  => $this->isNewRecord ? 'create' : 'update',
                        'el'  => $this->isNewRecord ? 'New shop was created' : 'Shop was updated',
                        'ev'  => $this->id
                    ]
                )
            );
            curl_setopt($ch, CURLOPT_HEADER, 0);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_exec($ch);
            curl_close($ch);
        } catch (Exception $e) {

        }
    }
}
