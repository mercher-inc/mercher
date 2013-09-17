<?php

/**
 * This is the model class for table "images".
 * The followings are the available columns in table 'images':
 * @property string $id
 * @property string $file_name
 * @property string $ext
 * @property string $dir
 * @property string $created
 * @property string $updated
 * The followings are the available model relations:
 * @property Products[] $products
 */
class Images extends CActiveRecord
{
    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'images';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('file_name, created', 'required'),
            array('file_name, dir', 'length', 'max' => 250),
            array('ext', 'length', 'max' => 5),
            array('updated', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, file_name, ext, dir, created, updated', 'safe', 'on' => 'search'),
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
            'products' => array(self::HAS_MANY, 'Products', 'image_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id'        => 'ID',
            'file_name' => 'File Name',
            'ext'       => 'Ext',
            'dir'       => 'Dir',
            'created'   => 'Created',
            'updated'   => 'Updated',
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
        $criteria->compare('file_name', $this->file_name, true);
        $criteria->compare('ext', $this->ext, true);
        $criteria->compare('dir', $this->dir, true);
        $criteria->compare('created', $this->created, true);
        $criteria->compare('updated', $this->updated, true);

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
     * @return Images the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }
}
