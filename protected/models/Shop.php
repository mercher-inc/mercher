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
 * @property string $title
 * @property string $description
 * @property string $tax
 * @property string $template_alias
 * @property string $template_config
 * @property boolean $is_active
 * @property boolean $is_banned
 * The followings are the available model relations:
 * @property User $owner
 * @property Template $template
 * @property Product[] $products
 * @property Category[] $categories
 */
class Shop extends CActiveRecord
{
    protected $_templateInstance;

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
            array('title', 'setDefaultTitle', 'on' => 'insert'),
            array('description, fb_id', 'default', 'value' => null),
            array('tax', 'default', 'value' => 0.00),
            array('is_active, is_banned', 'boolFilter'),
            array('fb_id, owner_id', 'required'),
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
            array('title, template_alias', 'length', 'max' => 50),
            array('tax', 'numerical', 'max' => 99.9999, 'min'=>0),
            array('is_active', 'checkActiveCount'),
            array('title, description, pp_merchant_id, is_active', 'safe'),
            array('fb_id', 'safe', 'on' => 'insert'),
            // The following rule is used by search().
            array(
                'id, created, updated, fb_id, owner_id, title, description, template_alias, is_active, is_banned, pp_merchant_id',
                'safe',
                'on' => 'search'
            ),
        );
    }

    public function setDefaultOwnerId()
    {
        $this->owner_id = Yii::app()->user->id;
    }

    public function setDefaultTitle()
    {
        $this->title = 'asdasdasd';
    }

    public function checkOwnerId()
    {
        if ($this->owner_id != Yii::app()->user->id) {
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
        if ($this->is_active) {
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
            if ($count > 10) {
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
            'owner'         => array(self::BELONGS_TO, 'User', 'owner_id'),
            'template'        => array(self::BELONGS_TO, 'Template', 'template_alias'),
            'products'      => array(self::HAS_MANY, 'Product', 'shop_id'),
            'productsCount'   => array(self::STAT, 'Product', 'shop_id'),
            'categories'    => array(self::HAS_MANY, 'Category', 'shop_id'),
            'categoriesCount' => array(self::STAT, 'Category', 'shop_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id'              => 'ID',
            'created'         => 'Created',
            'updated'         => 'Updated',
            'fb_id'           => 'Facebook page',
            'owner_id'        => 'Owner',
            'title'           => 'Title',
            'description'     => 'Description',
            'template_alias'  => 'Template Alias',
            'template_config' => 'Template Config',
            'is_active'       => 'Active',
            'is_banned'       => 'Banned',
            'pp_merchant_id'  => 'PayPal Merchant ID',
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
        $criteria->compare('template_alias', $this->template_alias, true);
        $criteria->compare('template_config', $this->template_config, true);
        $criteria->compare('is_active', $this->is_active);
        $criteria->compare('is_banned', $this->is_banned);
        $criteria->compare('pp_merchant_id', $this->pp_merchant_id, true);

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

    public function getTemplateInstance()
    {
        if (!$this->_templateInstance) {
            try {
                $config = CJSON::decode($this->template_config);
                if (!is_array($config)) {
                    $config = array();
                }
            } catch (Exception $e) {
                $config = array();
            }
            $this->_templateInstance = \Yii::createComponent(
                array(
                    'class'  => 'templates\\' . ($this->template_alias ? $this->template_alias : 'none') . '\\Template',
                    'shop'   => $this,
                    'config' => $config
                )
            );
        }
        return $this->_templateInstance;
    }
}
