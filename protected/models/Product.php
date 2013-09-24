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
 * @property string $description
 * @property string $image_id
 * @property string $price
 * @property boolean $is_active
 * @property boolean $is_banned
 * The followings are the available model relations:
 * @property Shop $shop
 * @property Category $category
 * @property Image $image
 */
class Product extends CActiveRecord
{
    public $new_image;

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
            array('description, price, category_id', 'default', 'value' => null),
            array('category_id', 'checkCategoryId', 'on' => 'insert, update'),
            array('is_active, is_banned', 'boolFilter'),
            array('shop_id, title', 'required'),
            array('title', 'length', 'max' => 50),
            array('price', 'numerical', 'max' => 999999999999999, 'min' => 0),
            array('is_active', 'checkActiveCount'),
            array(
                'new_image',
                'file',
                'allowEmpty' => true,
                'maxSize'    => 1024 * 1024,
                'mimeTypes'  => array('image/png', 'image/jpeg')
            ),
            array('new_image', 'uploadImage'),
            array('category_id, title, description, image_id, is_active', 'safe'),
            // The following rule is used by search().
            array(
                'id, created, updated, fb_id, shop_id, category_id, title, description, image_id, price, is_active, is_banned',
                'safe',
                'on' => 'search'
            ),
        );
    }

    public function uploadImage()
    {
        if ($this->new_image instanceof CUploadedFile) {
            $path = Yii::getPathOfAlias('webroot.images.shop_'.$this->shop_id.'.products');
            if (!file_exists($path) or !is_dir($path)) {
                mkdir($path, 0777, true);
            }
            $filename = md5($this->new_image->name) . ($this->new_image->extensionName?('.'.$this->new_image->extensionName):'');
            while (Image::model()->exists('original_file = :originalFile', array('originalFile'=>$path . DIRECTORY_SEPARATOR . $filename))) {
                $filename = md5($filename.time()) . ($this->new_image->extensionName?('.'.$this->new_image->extensionName):'');
            }
            $this->new_image->saveAs($path . DIRECTORY_SEPARATOR . $filename);

            $image = new Image();
            $image->original_file = $path . DIRECTORY_SEPARATOR . $filename;
            $image->data = CJSON::encode(array(
                    'origin'=>'/images/shop_'.$this->shop_id.'/products/'.$filename
                ));
            $image->save();
            $image->refresh();
            $this->image_id = $image->id;
        }
    }

    public function checkCategoryId()
    {
        if (
            $this->category_id and
            !Category::model()->exists(
                'shop_id = :shopId AND id = :categoryId',
                array(
                    'shopId'     => $this->shop_id,
                    'categoryId' => $this->category_id
                )
            )
        ) {
            $this->addError('category_id', $this->getAttributeLabel('category_id') . ' could not be found');
            return false;
        }
        return true;
    }

    public function boolFilter($field)
    {
        switch ($this->$field) {
            case true:
            case 't':
            case 'true':
            case 'y':
            case 'yes':
            case 'on':
            case '1':
                $this->$field = true;
                break;
            case false:
            case 'f':
            case 'false':
            case 'n':
            case 'no':
            case 'off':
            case '0':
                $this->$field = false;
                break;
            default:
                $this->addError($field, $this->getAttributeLabel($field) . ' could be true of false only');
                return false;
        }
        return false;
    }

    public function checkActiveCount()
    {
        if ($this->is_active) {
            if ($this->isNewRecord) {
                $count = (int)Product::model()->count(
                    'shop_id = :shopId AND is_active = TRUE',
                    array(
                        'shopId' => $this->shop_id
                    )
                );
            } else {
                $count = (int)Product::model()->count(
                    'shop_id = :shopId AND is_active = TRUE AND id != :productId',
                    array(
                        'shopId'    => $this->shop_id,
                        'productId' => $this->id
                    )
                );
            }
            $count++;
            if ($count > 25) {
                $this->addError('is_active', Yii::t('product', 'too_many_active'));
                return false;
            }
        }
        return true;
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
            'id'          => 'ID',
            'created'     => 'Created',
            'updated'     => 'Updated',
            'fb_id'       => 'Fb',
            'shop_id'     => 'Shop',
            'category_id' => 'Category',
            'title'       => 'Title',
            'description' => 'Description',
            'image_id'    => 'Image',
            'price'       => 'Price',
            'is_active'   => 'Is Active',
            'is_banned'   => 'Is Banned',
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
        $criteria->compare('shop_id', $this->shop_id, true);
        $criteria->compare('category_id', $this->category_id, true);
        $criteria->compare('title', $this->title, true);
        $criteria->compare('description', $this->description, true);
        $criteria->compare('image_id', $this->image_id, true);
        $criteria->compare('price', $this->price, true);
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
     * @return Product the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }
}
