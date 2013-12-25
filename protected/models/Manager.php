<?php

/**
 * This is the model class for table "manager".
 * The followings are the available columns in table 'manager':
 * @property string $user_id
 * @property string $shop_id
 * @property string $role
 * @property array $rolesList
 * @property string $userFbId
 */
class Manager extends CActiveRecord
{
    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'manager';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('user_id, shop_id', 'required'),
            array('userFbId', 'required', 'on' => 'insert'),
            array('rolesList', 'safe'),
            array('rolesList', 'checkRolesList'),
            array('role', 'unsafe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('user_id, shop_id, role', 'safe', 'on' => 'search'),
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
            'user' => array(self::BELONGS_TO, 'User', 'user_id'),
            'shop' => array(self::BELONGS_TO, 'Shop', 'shop_id')
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'user_id' => 'Manager',
            'shop_id' => 'Shop',
            'role'    => 'Role',
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

        $criteria->compare('user_id', $this->user_id);
        $criteria->compare('shop_id', $this->shop_id);
        $criteria->compare('role', $this->role);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Manager the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public function setRolesList($rolesList)
    {
        $availableRoles = [
            AuthManager::ROLE_SHOP_MANAGER,
            AuthManager::ROLE_PRODUCTS_MANAGER,
            AuthManager::ROLE_CATEGORIES_MANAGER,
        ];
        if (!is_array($rolesList)) {
            $rolesList = array();
        }
        $rolesList  = array_intersect($rolesList, $availableRoles);
        $rolesList  = array_unique($rolesList);
        $this->role = '{' . implode(',', $rolesList) . '}';
    }

    public function getRolesList()
    {
        if (!trim($this->role, '{}')) {
            return array();
        }
        return explode(',', trim($this->role, '{}'));
    }

    public function checkRolesList()
    {
        if (!count($this->rolesList)) {
            $this->addError('rolesList', 'At least one role is required');
        }
    }

    public function setUserFbId($userFbId)
    {
        try {
            $managerProfile = Yii::app()->facebook->sdk->api(
                $userFbId . '?' . http_build_query(
                    [
                        'fields' => 'id,first_name,last_name,username',
                    ]
                )
            );
        } catch (FacebookApiException $e) {
            throw new CHttpException(500, $e->getMessage());
        }

        if (!isset($managerProfile['id'])) {
            $this->addError('userFbId', 'Unknown user');
            return false;
        }

        $managerModel = User::model()->findByAttributes(
            [
                'fb_id' => $managerProfile['id']
            ]
        );

        if (!$managerModel) {
            $managerModel             = new User();
            $managerModel->fb_id      = $managerProfile['id'];
            $managerModel->first_name = $managerProfile['first_name'];
            $managerModel->last_name  = $managerProfile['last_name'];
            $managerModel->email      = (isset($managerProfile['username']) ? $managerProfile['username'] : $managerProfile['id']) . '@facebook.com';
            $managerModel->save();
        }
        $this->user_id = $managerModel->id;
        return true;
    }

    public function getUserFbId()
    {
        if (!$this->user) {
            return null;
        }
        return $this->user->fb_id;
    }
}
