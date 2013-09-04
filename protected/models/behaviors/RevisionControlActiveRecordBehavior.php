<?php
/**
 * Created by JetBrains PhpStorm.
 * User: dmitry
 * Date: 7/9/13
 * Time: 12:37 PM
 * To change this template use File | Settings | File Templates.
 */

class RevisionControlActiveRecordBehavior extends CActiveRecordBehavior
{
    public function beforeValidate(CModelEvent $event)
    {
        $model = $this->getOwner();
        if (!$model->revision) {
            $model->setAttribute('revision', '1:' . md5(time()));
        }
    }

    public function beforeSave(CModelEvent $event)
    {
        $model = $this->getOwner();
        if ($model->getIsNewRecord() or !$model->revision) {
            $model->revision = '1:' . md5(time());
        } else {
            try {
                list($revision_id, $revision_key) = explode(':', $model->revision);
            } catch (Exception $e) {
                $revision_id  = 1;
                $revision_key = md5(time());
            }
            $revision_id++;
            $revision_key    = md5(time() . $revision_key);
            $model->revision = $revision_id . ':' . $revision_key;
        }
    }
}