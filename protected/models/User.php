<?php

/**
 * This is the model class for table "user".
 * The followings are the available columns in table 'user':
 * @property string $id
 * @property string $created
 * @property string $updated
 * @property string $fb_id
 * @property string $email
 * @property string $first_name
 * @property string $last_name
 * @property boolean $is_banned
 * @property string $last_login
 * The followings are the available model relations:
 * @property Shop[] $shops
 * @property integer $shopsCount
 * @property Shop[] $managedShops
 * @property integer $managedShopsCount
 * @property CartItem[] $cartItems
 */
class User extends CActiveRecord
{
    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'user';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('fb_id, email', 'required'),
            array('email', 'length', 'max' => 250),
            array('first_name, last_name', 'length', 'max' => 50),
            array('email, first_name, last_name', 'safe'),
            // The following rule is used by search().
            array(
                'id, created, updated, fb_id, email, first_name, last_name, is_banned, last_login',
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
            'shops' => array(self::HAS_MANY, 'Shop', 'owner_id'),
            'shopsCount' => array(self::STAT, 'Shop', 'owner_id'),
            'managedShops' => array(self::MANY_MANY, 'Shop', 'manager(user_id, shop_id)'),
            'managedShopsCount' => array(self::STAT, 'Shop', 'manager(user_id, shop_id)'),
            'cartItems' => array(self::HAS_MANY, 'CartItem', 'user_id'),
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
            'fb_id'      => 'Fb',
            'email'      => 'Email',
            'first_name' => 'First Name',
            'last_name'  => 'Last Name',
            'is_banned'  => 'Is Banned',
            'last_login' => 'Last Login',
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
        $criteria->compare('email', $this->email, true);
        $criteria->compare('first_name', $this->first_name, true);
        $criteria->compare('last_name', $this->last_name, true);
        $criteria->compare('is_banned', $this->is_banned);
        $criteria->compare('last_login', $this->last_login, true);

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
     * @return User the static model class
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
                        'ec'  => 'user',
                        'ea'  => $this->isNewRecord ? 'create' : 'update',
                        'el'  => $this->isNewRecord ? 'New user was created' : 'User was updated',
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

    public function getName()
    {
        return $this->first_name . ' ' . $this->last_name;
    }
}
