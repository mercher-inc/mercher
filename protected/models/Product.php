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
 * @property string $amount
 * @property integer $quantity_in_stock
 * @property boolean $is_active
 * @property boolean $is_banned
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
            array('description, amount, quantity_in_stock, category_id, image_id', 'default', 'value' => null),
            array('category_id', 'checkCategoryId', 'on' => 'insert, update'),
            array('is_active, is_banned', 'boolFilter'),
            array('shop_id, title', 'required'),
            array('quantity_in_stock', 'numerical', 'integerOnly' => true, 'min' => 0),
            array('title', 'length', 'max' => 50),
            array('amount', 'numerical', 'max' => 999999999999999, 'min' => 0),
            array('is_active', 'checkActiveCount'),
            array('category_id, amount, quantity_in_stock, description, image_id, is_active', 'safe'),
            // The following rule is used by search().
            array(
                'id, created, updated, fb_id, shop_id, category_id, title, description, image_id, amount, is_active, is_banned, quantity_in_stock',
                'safe',
                'on' => 'search'
            ),
        );
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
            if ($count > $this->shop->maxProductsCount) {
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
            'id'                => 'ID',
            'created'           => 'Created',
            'updated'           => 'Updated',
            'fb_id'             => 'Fb',
            'shop_id'           => 'Shop',
            'category_id'       => 'Category',
            'title'             => 'Title',
            'description'       => 'Description',
            'image_id'          => 'Image',
            'amount'            => 'Price',
            'is_active'         => 'Show in shop',
            'is_banned'         => 'Banned',
            'quantity_in_stock' => 'Quantity In Stock',
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

        $criteria->compare('id', $this->id);
        $criteria->compare('created', $this->created, true);
        $criteria->compare('updated', $this->updated, true);
        $criteria->compare('fb_id', $this->fb_id);
        $criteria->compare('shop_id', $this->shop_id);
        $criteria->compare('category_id', $this->category_id);
        $criteria->compare('title', $this->title, true);
        $criteria->compare('description', $this->description, true);
        $criteria->compare('image_id', $this->image_id);
        $criteria->compare('amount', $this->amount, true);
        $criteria->compare('is_active', $this->is_active);
        $criteria->compare('is_banned', $this->is_banned);
        $criteria->compare('quantity_in_stock', $this->quantity_in_stock);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    public function behaviors()
    {
        return array(
            'application.models.behaviors.CreateUpdateTimeActiveRecordBehavior',
            'application.models.behaviors.OgProductBehavior',
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

    protected function afterValidate()
    {
        parent::afterValidate();

        try {
            $response = Yii::app()->facebook->sdk->api(
                $this->shop->fb_id . '?' . http_build_query(['fields' => 'is_published'])
            );
        } catch (FacebookApiException $e) {
            $this->addError('shop_id', 'Facebook api error');
            return;
        }

        if (!isset($response['is_published']) or !$response['is_published']) {
            $this->addError('shop_id', 'Fan page is not published');
            return;
        }

        return;
    }

    public function getOgParams()
    {
        $object = array(
            'og:title'         => $this->title,
            'og:type'          => 'product',
            'og:locale'        => 'en_US',
            'product:retailer' => $this->shop->fb_id,
            'fb:admins'        => $this->shop->owner->fb_id,
            'fb:app_id'        => Yii::app()->facebook->sdk->getAppId(),
        );
        if ($this->amount) {
            $object['product:price:amount']   = $this->amount;
            $object['product:price:currency'] = 'USD';
        }
        if ($this->description) {
            $object['og:description'] = $this->description;
        }

        if ($this->category) {
            $object['product:category'] = $this->category->title;
        }

        if ($this->image) {
            $data               = CJSON::decode($this->image->data);
            $object['og:image'] = str_replace(
                'app.mercher',
                'mercher',
                Yii::app()->urlManager->createUrl('/') . $data['xl']
            );
        }

        $object['og:url'] = str_replace(
            'app.mercher',
            'mercher',
            Yii::app()->urlManager->createUrl('og/products', ['product_id' => $this->id])
        );

        $object['product:product_link'] = 'https://www.facebook.com/' . $this->shop->fb_id . '?' . http_build_query(
            array(
                'sk'       => 'app_' . Yii::app()->facebook->sdk->getAppId(),
                'app_data' => CJSON::encode(
                    array(
                        'product_id' => $this->id
                    )
                )
            )
        );

        return $object;
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
                        'ec'  => 'product',
                        'ea'  => $this->isNewRecord ? 'create' : 'update',
                        'el'  => $this->isNewRecord ? 'New product was created' : 'Product was updated',
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
}
