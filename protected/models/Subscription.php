<?php

/**
 * This is the model class for table "subscription".
 * The followings are the available columns in table 'subscription':
 * @property string $id
 * @property string $created
 * @property string $updated
 * @property string $title
 * @property string $description
 * @property string $image
 * @property string $price
 * @property integer $trial_duration
 * @property integer $products_count
 * @property boolean $is_public
 * @property Shop[] $shops
 * @property integer $shopsCount
 */
class Subscription extends CActiveRecord
{
    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'subscription';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('created, title, image, price', 'required'),
            array('trial_duration, products_count', 'numerical', 'integerOnly' => true),
            array('title, image', 'length', 'max' => 250),
            array('price', 'length', 'max' => 9),
            array('updated, description', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array(
                'id, created, updated, title, description, image, price, trial_duration, products_count',
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
            'shops'      => array(self::HAS_MANY, 'Shop', 'subscription_id'),
            'shopsCount' => array(self::STAT, 'Shop', 'subscription_id'),
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
            'title'          => 'Title',
            'description'    => 'Description',
            'image'          => 'Image',
            'price'          => 'Price',
            'trial_duration' => 'Trial Duration',
            'products_count' => 'Products Count',
            'shopsCount'     => 'Used in shops'
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
        // @todo Please modify the following code to remove attributes that should not be searched.

        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id, true);
        $criteria->compare('created', $this->created, true);
        $criteria->compare('updated', $this->updated, true);
        $criteria->compare('title', $this->title, true);
        $criteria->compare('description', $this->description, true);
        $criteria->compare('image', $this->image, true);
        $criteria->compare('price', $this->price, true);
        $criteria->compare('trial_duration', $this->trial_duration);
        $criteria->compare('products_count', $this->products_count);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Subscription the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public function behaviors()
    {
        return array(
            'application.models.behaviors.CreateUpdateTimeActiveRecordBehavior',
        );
    }
}
