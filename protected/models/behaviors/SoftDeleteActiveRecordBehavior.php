<?php
/**
 * Created by JetBrains PhpStorm.
 * User: dmitry
 * Date: 7/4/13
 * Time: 5:32 PM
 * To change this template use File | Settings | File Templates.
 */

//Yii::import('system.db.ar.CActiveRecordbehavior');

class SoftDeleteActiveRecordBehavior extends CActiveRecordBehavior
{
    public function beforeDelete(CModelEvent $event)
    {
        $model = $this->getOwner();
        $model->setAttribute('deleted', date('Y-m-d h:i:s'));
        $model->save();
        $event->isValid = false;
    }
}