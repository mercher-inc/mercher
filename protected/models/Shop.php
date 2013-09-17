<?php

/**
 * This is the model class for table "shop".
 * The followings are the available columns in table 'shop':
 * @property string $id
 * @property string $created
 * @property string $updated
 * @property string $owner_id
 * @property string $title
 * @property string $description
 * @property boolean $is_active
 * @property string $banned
 * The followings are the available model relations:
 * @property Showcase[] $showcases
 * @property User $owner
 * @property Product[] $products
 * @property Category[] $categories
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
            // The following rule is used by search().
            array('id, created, updated, owner_id, title, description, is_active, banned', 'safe', 'on' => 'search'),
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
            'showcases'  => array(self::HAS_MANY, 'Showcase', 'shop_id'),
            'owner'      => array(self::BELONGS_TO, 'User', 'owner_id'),
            'products'   => array(self::HAS_MANY, 'Product', 'shop_id'),
            'categories' => array(self::HAS_MANY, 'Category', 'shop_id'),
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
            'owner_id'    => 'Owner',
            'title'       => 'Title',
            'description' => 'Description',
            'is_active'   => 'Is Active',
            'banned'      => 'Banned',
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
        $criteria->compare('owner_id', $this->owner_id, true);
        $criteria->compare('title', $this->title, true);
        $criteria->compare('description', $this->description, true);
        $criteria->compare('is_active', $this->is_active);
        $criteria->compare('banned', $this->banned, true);

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
