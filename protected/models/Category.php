<?php

/**
 * This is the model class for table "category".
 * The followings are the available columns in table 'category':
 * @property string $id
 * @property string $created
 * @property string $updated
 * @property string $shop_id
 * @property string $title
 * @property string $description
 * @property boolean $is_active
 * @property boolean $is_banned
 * The followings are the available model relations:
 * @property Product[] $products
 * @property Shop $shop
 */
class Category extends CActiveRecord
{
    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'category';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('description', 'default', 'value' => null),
            array('is_active, is_banned', 'boolFilter'),
            array('shop_id, title', 'required'),
            array('title', 'length', 'max' => 50),
            array('is_active', 'checkActiveCount'),
            array('title, description, is_active', 'safe'),
            // The following rule is used by search().
            array('id, created, updated, shop_id, title, description, is_active, is_banned', 'safe', 'on' => 'search'),
        );
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
                $count = (int)Category::model()->count(
                    'shop_id = :shopId AND is_active = TRUE',
                    array(
                        'shopId' => $this->shop_id
                    )
                );
            } else {
                $count = (int)Category::model()->count(
                    'shop_id = :shopId AND is_active = TRUE AND id != :categoryId',
                    array(
                        'shopId'     => $this->shop_id,
                        'categoryId' => $this->id
                    )
                );
            }
            $count++;
            if ($count > 10) {
                $this->addError('is_active', Yii::t('category', 'too_many_active'));
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
            'products' => array(self::HAS_MANY, 'Product', 'category_id'),
            'shop'     => array(self::BELONGS_TO, 'Shop', 'shop_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id'          => 'ID',
            'created'     => 'Created',
            'updated'     => 'Updated',
            'shop_id'     => 'Shop',
            'title'       => 'Title',
            'description' => 'Description',
            'is_active'   => 'Active',
            'is_banned'   => 'Banned',
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

        $criteria->compare('id', $this->id);
        $criteria->compare('created', $this->created, true);
        $criteria->compare('updated', $this->updated, true);
        $criteria->compare('shop_id', $this->shop_id);
        $criteria->compare('title', $this->title, true);
        $criteria->compare('description', $this->description, true);
        $criteria->compare('is_active', $this->is_active);
        $criteria->compare('is_banned', $this->is_banned);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    public function behaviors()
    {
        return array(
            'application.models.behaviors.CreateUpdateTimeActiveRecordBehavior',
        );
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Category the static model class
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
                http_build_query([
                        'v'   => 1,
                        'tid' => 'UA-23393444-12',
                        'cid' => 555,
                        't'   => 'event',
                        'ec'  => 'category',
                        'ea'  => $this->isNewRecord?'create':'update',
                        'el'  => $this->shop->title,
                    ])
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
