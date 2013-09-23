<?php

/**
 * This is the model class for table "shop".
 * The followings are the available columns in table 'shop':
 * @property string $id
 * @property string $created
 * @property string $updated
 * @property string $fb_id
 * @property string $owner_id
 * @property string $title
 * @property string $description
 * @property boolean $is_active
 * @property boolean $is_banned
 * The followings are the available model relations:
 * @property Product[] $products
 * @property Category[] $categories
 * @property User $owner
 */
class Shop extends CActiveRecord
{
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
            array('owner_id, title', 'required'),
            array('title', 'length', 'max' => 50),
            array('title, description, is_active', 'safe'),
            array('fb_id', 'safe', 'on' => 'insert'),
            // The following rule is used by search().
            array(
                'id, created, updated, fb_id, owner_id, title, description, is_active, is_banned',
                'safe',
                'on' => 'search'
            ),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations()
    {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'products'   => array(self::HAS_MANY, 'Product', 'shop_id'),
            'categories' => array(self::HAS_MANY, 'Category', 'shop_id'),
            'owner'      => array(self::BELONGS_TO, 'User', 'owner_id'),
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
            'fb_id'       => 'Facebook page',
            'owner_id'    => 'Owner',
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

        $criteria->compare('id', $this->id, true);
        $criteria->compare('created', $this->created, true);
        $criteria->compare('updated', $this->updated, true);
        $criteria->compare('fb_id', $this->fb_id, true);
        $criteria->compare('owner_id', $this->owner_id, true);
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
     * @return Shop the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }
}
