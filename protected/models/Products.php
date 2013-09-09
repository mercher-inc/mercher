<?php

/**
 * This is the model class for table "products".
 *
 * The followings are the available columns in table 'products':
 * @property string $id
 * @property string $shop_id
 * @property string $category_id
 * @property string $title
 * @property string $plural_title
 * @property string $brand
 * @property string $description
 * @property string $image_id
 * @property string $price
 * @property string $banned
 * @property string $created
 * @property string $updated
 * @property string $deleted
 * @property string $revision
 *
 * The followings are the available model relations:
 * @property Shops $shop
 * @property Categories $category
 * @property Images $image
 */
class Products extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'products';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id, shop_id, created', 'required'),
			array('title, plural_title, brand, revision', 'length', 'max'=>50),
			array('price', 'length', 'max'=>19),
			array('category_id, description, image_id, banned, updated, deleted', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, shop_id, category_id, title, plural_title, brand, description, image_id, price, banned, created, updated, deleted, revision', 'safe', 'on'=>'search'),
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
			'shop' => array(self::BELONGS_TO, 'Shops', 'shop_id'),
			'category' => array(self::BELONGS_TO, 'Categories', 'category_id'),
			'image' => array(self::BELONGS_TO, 'Images', 'image_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'shop_id' => 'Shop',
			'category_id' => 'Category',
			'title' => 'Title',
			'plural_title' => 'Plural Title',
			'brand' => 'Brand',
			'description' => 'Description',
			'image_id' => 'Image',
			'price' => 'Price',
			'banned' => 'Banned',
			'created' => 'Created',
			'updated' => 'Updated',
			'deleted' => 'Deleted',
			'revision' => 'Revision',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id,true);
		$criteria->compare('shop_id',$this->shop_id,true);
		$criteria->compare('category_id',$this->category_id,true);
		$criteria->compare('title',$this->title,true);
		$criteria->compare('plural_title',$this->plural_title,true);
		$criteria->compare('brand',$this->brand,true);
		$criteria->compare('description',$this->description,true);
		$criteria->compare('image_id',$this->image_id,true);
		$criteria->compare('price',$this->price,true);
		$criteria->compare('banned',$this->banned,true);
		$criteria->compare('created',$this->created,true);
		$criteria->compare('updated',$this->updated,true);
		$criteria->compare('deleted',$this->deleted,true);
		$criteria->compare('revision',$this->revision,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

    public function behaviors()
    {
        return array(
            'application.models.behaviors.OgProductBehavior',
            'application.models.behaviors.SoftDeleteActiveRecordBehavior',
            'application.models.behaviors.CreateUpdateTimeActiveRecordBehavior',
            'application.models.behaviors.RevisionControlActiveRecordBehavior'
        );
    }

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Products the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
