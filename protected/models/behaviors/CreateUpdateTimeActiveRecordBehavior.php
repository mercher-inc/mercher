<?php
/**
 * Created by JetBrains PhpStorm.
 * User: dmitry
 * Date: 7/9/13
 * Time: 12:30 PM
 * To change this template use File | Settings | File Templates.
 */

class CreateUpdateTimeActiveRecordBehavior extends CActiveRecordBehavior
{
    public function beforeValidate(CModelEvent $event)
    {
        $model = $this->getOwner();
        if ($model->getIsNewRecord()) {
            $model->setAttribute('created', date('Y-m-d h:i:s'));
        } else {
            $model->setAttribute('updated', date('Y-m-d h:i:s'));
        }
    }
}