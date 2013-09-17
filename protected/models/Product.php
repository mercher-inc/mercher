<?php

/**
 * This is the model class for table "product".
 * The followings are the available columns in table 'product':
 * @property string $id
 * @property string $created
 * @property string $updated
 * @property string $fb_id
 * @property string $shop_id
 * @property string $category_id
 * @property string $title
 * @property string $plural_title
 * @property string $brand
 * @property string $description
 * @property string $image_id
 * @property string $price
 * @property string $banned
 * The followings are the available model relations:
 * @property Shop $shop
 * @property Category $category
 * @property Image $image
 */
class Product extends CActiveRecord
{
    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'product';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('created, fb_id, shop_id', 'required'),
            array('title, plural_title, brand', 'length', 'max' => 50),
            array('price', 'length', 'max' => 19),
            array('updated, category_id, description, image_id, banned', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array(
                'id, created, updated, fb_id, shop_id, category_id, title, plural_title, brand, description, image_id, price, banned',
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
            'shop'     => array(self::BELONGS_TO, 'Shop', 'shop_id'),
            'category' => array(self::BELONGS_TO, 'Category', 'category_id'),
            'image'    => array(self::BELONGS_TO, 'Image', 'image_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id'           => 'ID',
            'created'      => 'Created',
            'updated'      => 'Updated',
            'fb_id'        => 'Fb',
            'shop_id'      => 'Shop',
            'category_id'  => 'Category',
            'title'        => 'Title',
            'plural_title' => 'Plural Title',
            'brand'        => 'Brand',
            'description'  => 'Description',
            'image_id'     => 'Image',
            'price'        => 'Price',
            'banned'       => 'Banned',
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
        $criteria->compare('fb_id', $this->fb_id, true);
        $criteria->compare('shop_id', $this->shop_id, true);
        $criteria->compare('category_id', $this->category_id, true);
        $criteria->compare('title', $this->title, true);
        $criteria->compare('plural_title', $this->plural_title, true);
        $criteria->compare('brand', $this->brand, true);
        $criteria->compare('description', $this->description, true);
        $criteria->compare('image_id', $this->image_id, true);
        $criteria->compare('price', $this->price, true);
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
     * @return Product the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }
}
