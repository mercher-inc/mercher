<?php

/**
 * This is the model class for table "cart_item".
 * The followings are the available columns in table 'cart_item':
 * @property string $id
 * @property string $created
 * @property string $updated
 * @property string $user_id
 * @property string $product_id
 * @property integer $amount
 * The followings are the available model relations:
 * @property User $user
 * @property Product $product
 */
class CartItem extends CActiveRecord
{
    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'cart_item';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('created, user_id, product_id, amount', 'required'),
            array('amount', 'numerical', 'integerOnly' => true),
            array('updated', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, created, updated, user_id, product_id, amount', 'safe', 'on' => 'search'),
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
            'user'    => array(self::BELONGS_TO, 'User', 'user_id'),
            'product' => array(self::BELONGS_TO, 'Product', 'product_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id'         => 'ID',
            'created'    => 'Created',
            'updated'    => 'Updated',
            'user_id'    => 'User',
            'product_id' => 'Product',
            'amount'     => 'Amount',
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
        $criteria->compare('user_id', $this->user_id, true);
        $criteria->compare('product_id', $this->product_id, true);
        $criteria->compare('amount', $this->amount);

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
     * @return CartItem the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }
}
