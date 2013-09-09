<?php

/**
 * This is the model class for table "categories".
 *
 * The followings are the available columns in table 'categories':
 * @property string $id
 * @property string $shop_id
 * @property string $title
 * @property string $description
 * @property string $created
 * @property string $updated
 * @property string $deleted
 * @property string $revision
 *
 * The followings are the available model relations:
 * @property Products[] $products
 * @property Shops $shop
 */
class Categories extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'categories';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('shop_id, title, created', 'required'),
			array('title, revision', 'length', 'max'=>50),
			array('description, updated, deleted', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, shop_id, title, description, created, updated, deleted, revision', 'safe', 'on'=>'search'),
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
			'products' => array(self::HAS_MANY, 'Products', 'category_id'),
			'shop' => array(self::BELONGS_TO, 'Shops', 'shop_id'),
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
			'title' => 'Title',
			'description' => 'Description',
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
		$criteria->compare('title',$this->title,true);
		$criteria->compare('description',$this->description,true);
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
            'application.models.behaviors.SoftDeleteActiveRecordBehavior',
            'application.models.behaviors.CreateUpdateTimeActiveRecordBehavior',
            'application.models.behaviors.RevisionControlActiveRecordBehavior',
            'restfulModelBehavior' => array(
                'class'            => 'application.models.behaviors.RestfulModelBehavior',
                'formClass'        => 'CategoriesRestForm',
                'notFoundMessage'  => Yii::t('error', 'categories_not_found'),
                'forbiddenMessage' => Yii::t('error', 'categories_forbidden'),
            )
        );
    }

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Categories the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}

class CategoriesRestForm extends CFormModel implements RestFormInterface
{
    public $shop_id;
    public $category_id;
    public $page;
    public $limit;
    public $with;
    public $scopes;

    public function rules()
    {
        return array(
            array('shop_id', 'required'),
            array('category_id', 'required', 'on' => array('read', 'update', 'delete')),
            array('page', 'default', 'value' => 1),
            array('limit', 'default', 'value' => 10),
            array('with, scopes', 'default', 'value' => array()),
            array('page, limit', 'type', 'type' => 'integer'),
            array('shop_id, category_id', 'type', 'type' => 'integer'),
        );
    }

    public function getModelIdParam()
    {
        return 'category_id';
    }

    public function getModelId()
    {
        return $this->category_id;
    }

    public function getUrl()
    {
        $context = array();
        switch ($this->getScenario()) {
            case 'list':
            case 'create':
                $route = 'api/categories/list';
                break;
            case 'read':
            case 'update':
            case 'delete':
            case 'patch':
                $route = 'api/categories/read';
                if ($this->category_id !== null) {
                    $context['category_id'] = $this->category_id;
                }
                break;
            default:
                $route = '';
        }
        if ($this->shop_id !== null) {
            $context['shop_id'] = $this->shop_id;
        }
        if ($this->with !== null and is_array($this->with) and count($this->with)) {
            $context['with'] = $this->with;
        }
        if ($this->scopes !== null and is_array($this->scopes) and count($this->scopes)) {
            $context['scopes'] = $this->scopes;
        }
        return Yii::app()->urlManager->createUrl($route, $context);
    }

    public function getContext()
    {
        // user context
        if ($this->shop_id !== null) {
            $shop = Shops::model()->findByPk($this->shop_id);
            if ($shop) {
                return array($shop, 'categories', 'categories_count');
            } else {
                throw new \CHttpException(404, \Yii::t('error', 'shop_not_found'));
            }
        }

        return array(null, null, null);
    }
}