<?php

/**
 * This is the model class for table "order".
 * The followings are the available columns in table 'order':
 * @property string $id
 * @property string $created
 * @property string $updated
 * @property string $shop_id
 * @property string $user_id
 * @property string $pay_key
 * @property string $status
 * @property string $total
 * The followings are the available model relations:
 * @property OrderItem[] $orderItems
 * @property User $user
 * @property Shop $shop
 */
class Order extends CActiveRecord
{
    const STATUS_NEW                 = 'new';
    const STATUS_WAITING_FOR_PAYMENT = 'waiting_for_payment';
    const STATUS_ACCEPTED            = 'accented';
    const STATUS_REJECTED            = 'rejected';
    const STATUS_APPROVED            = 'approved';
    const STATUS_COMPLETED           = 'completed';

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'order';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('created, shop_id, user_id', 'required'),
            array('pay_key', 'length', 'max' => 50),
            array('total', 'length', 'max' => 9),
            array('updated, status', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, created, updated, shop_id, user_id, pay_key, status', 'safe', 'on' => 'search'),
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
            'orderItems' => array(self::HAS_MANY, 'OrderItem', 'order_id'),
            'user'       => array(self::BELONGS_TO, 'User', 'user_id'),
            'shop'       => array(self::BELONGS_TO, 'Shop', 'shop_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id'      => 'ID',
            'created' => 'Created',
            'updated' => 'Updated',
            'shop_id' => 'Shop',
            'user_id' => 'User',
            'pay_key' => 'Pay Key',
            'status'  => 'Status',
            'total'   => 'Total',
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
        $criteria->compare('shop_id', $this->shop_id, true);
        $criteria->compare('user_id', $this->user_id, true);
        $criteria->compare('pay_key', $this->pay_key, true);
        $criteria->compare('status', $this->status, true);
        $criteria->compare('total', $this->total, true);

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
     * @return Order the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public function updateTotal()
    {
        $this->total = 0;
        foreach ($this->orderItems as $item) {
            $this->total += $item->price * $item->amount;
        }
        $this->save();
    }
}
