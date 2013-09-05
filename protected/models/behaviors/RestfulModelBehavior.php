<?php
/**
 * Project: Rallyware v2
 * Author: Dmitry Les
 * Date: 8/19/13
 * Time: 8:16 PM
 */

class RestfulModelBehavior extends CActiveRecordBehavior
{
    /**
     * @var
     */
    public $formClass;
    /**
     * @var
     */
    protected $forms = array();
    /**
     * @var
     */
    public $readPermission;
    /**
     * @var
     */
    public $createPermission;
    /**
     * @var
     */
    public $updatePermission;
    /**
     * @var
     */
    public $deletePermission;
    /**
     * @var
     */
    public $readForbiddenMessage;
    /**
     * @var
     */
    public $notFoundMessage;
    /**
     * @var
     */
    public $forbiddenMessage;

    public function getRestForm($scenario)
    {
        return new $this->formClass($scenario);
    }

    /**
     * @param array $attributes Request attributes
     * @return array Ready for widget or api collection
     * @throws CHttpException
     */
    public function readRestCollection(array $attributes = array())
    {
        //getting model's rest form
        $form = $this->getRestForm('list');
        //filling form with attributes
        $form->attributes = $attributes;
        //validating the form
        if (!$form->validate()) {
            throw new CHttpException(400);
        }

        //getting page and limit of collection
        $page  = (int)$form->page;
        $limit = (int)$form->limit;

        //default collection structure
        $collection = array(
            'models' => array(),
            'url'    => $form->getUrl(),
            'count'  => 0,
            'page'   => $page,
            'limit'  => $limit
        );

        //getting context of requested collection
        list($context, $relation, $relationCount) = $form->getContext();

        if ($context) {
            //getting collection's models from context
            $models = $context->$relation(
                array(
                    'scopes' => $form->scopes,
                    'limit'  => $limit,
                    'offset' => ($page - 1) * $limit
                )
            );
        } else {
            $models = $this->getOwner()->findAll(
                array(
                    'scopes' => $form->scopes,
                    'limit'  => $limit,
                    'offset' => ($page - 1) * $limit
                )
            );
        }

        //filling collection with models data
        foreach ($models as $model) {
            $modelAttributes = $model->getAttributes();
            $this->addRelations($form->with, $model, $form, $modelAttributes);
            $collection['models'][] = $modelAttributes;
        }

        if ($context) {
            //filling collection models count
            $collection['count'] = (int)$context->$relationCount(
                array(
                    'scopes' => $form->scopes,
                )
            );
        } else {
            //filling collection models count
            $collection['count'] = (int)$this->getOwner()->count(
                array(
                    'scopes' => $form->scopes,
                )
            );
        }

        //returning the built collection
        return $collection;
    }

    /**
     * @param array $attributes Request attributes
     * @return mixed Ready for widget or api model
     * @throws CHttpException
     */
    public function readRestModel(array $attributes = array())
    {
        //getting model's rest form
        $form = $this->getRestForm('read');
        //filling form with attributes
        $form->attributes = $attributes;
        //validating the form
        if (!$form->validate()) {
            throw new CHttpException(400);
        }

        //getting context of requested model
        list($context, $relation, $relationCount) = $form->getContext();

        if ($context) {
            //getting collection's models from context
            $models = $context->$relation(
                array(
                    'scopes'    => $form->scopes,
                    'limit'     => 1,
                    'condition' => $relation . '.id=:modelId',
                    'params'    => array(
                        'modelId' => $form->getModelId()
                    ),
                )
            );

            //check collection size
            if (!count($models)) {
                throw new CHttpException(404, $this->notFoundMessage);
            }

            //getting model from collection
            $model = array_shift($models);
        } else {
            //getting collection's models from context
            $model = $this->getOwner()->findByPk(
                $form->getModelId(),
                array(
                    'scopes' => $form->scopes
                )
            );

            //check model existence
            if (!count($model)) {
                throw new CHttpException(404, $this->notFoundMessage);
            }
        }

        //building the model's attributes array
        $modelAttributes = $model->getAttributes();
        //adding model's url
        $modelAttributes['_url'] = $form->getUrl();
        //adding relations data
        $this->addRelations($form->with, $model, $form, $modelAttributes);

        //returning the built model
        return $modelAttributes;
    }

    /**
     *
     */
    public function createRestModel(array $data, array $attributes = array())
    {
        //getting model's rest form
        $form = $this->getRestForm('create');
        //filling form with attributes
        $form->attributes = $attributes;
        //validating the form
        if (!$form->validate()) {
            throw new CHttpException(400);
        }
        if (!isset($data['company_id'])) {
            $data['company_id'] = $form->company_id;
        }

        //getting model's class
        $modelClass = get_class($this->getOwner());
        //creation of new model instance
        $model = new $modelClass;
        //filling new model with data
        $model->attributes = $data;

        //saving model to database
        if (!$model->save()) {
            //if something is wrong - through an exception
            throw new \ValidationException(406, \Yii::t('error', 'validation'), $model->getErrors());
        }

        //getting new model's rest form
        $form = $this->getRestForm('read');
        //setting ID attribute
        $attributes[$form->getModelIdParam()] = $model->id;
        //filling form with attributes
        $form->attributes = $attributes;

        //building the model's attributes array
        $modelAttributes = $model->getAttributes();
        //adding model's url
        $modelAttributes['_url'] = $form->getUrl();
        //adding relations data
        $this->addRelations($form->with, $model, $form, $modelAttributes);

        //returning the built model
        return $modelAttributes;
    }

    /**
     *
     */
    public function updateRestModel(array $data, array $attributes = array())
    {
        //getting model's rest form
        $form = $this->getRestForm('update');
        //filling form with attributes
        $form->attributes = $attributes;
        //validating the form
        if (!$form->validate()) {
            throw new CHttpException(400);
        }

        //getting context of requested model
        list($context, $relation, $relationCount) = $form->getContext();

        if ($context) {
            //getting collection's models from context
            $models = $context->$relation(
                array(
                    'scopes'    => $form->scopes,
                    'limit'     => 1,
                    'condition' => $relation . '.id=:modelId',
                    'params'    => array(
                        'modelId' => $form->getModelId()
                    ),
                )
            );

            //check collection size
            if (!count($models)) {
                throw new CHttpException(404, $this->notFoundMessage);
            }

            //getting model from collection
            $model = array_shift($models);
        } else {
            //getting collection's models from context
            $model = $this->getOwner()->findByPk(
                $form->getModelId(),
                array(
                    'scopes' => $form->scopes
                )
            );

            //check model existence
            if (!count($model)) {
                throw new CHttpException(404, $this->notFoundMessage);
            }
        }

        //filling model with data
        $model->attributes = $data;

        //saving model to database
        if (!$model->save()) {
            //if something is wrong - through an exception
            throw new \ValidationException(406, \Yii::t('error', 'validation'), $model->getErrors());
        }

        //building the model's attributes array
        $modelAttributes = $model->getAttributes();
        //adding model's url
        $modelAttributes['_url'] = $form->getUrl();
        //adding relations data
        $this->addRelations($form->with, $model, $form, $modelAttributes);

        //returning the built model
        return $modelAttributes;
    }

    /**
     *
     */
    public function deleteRestModel(array $attributes = array())
    {
        //getting model's rest form
        $form = $this->getRestForm('update');
        //filling form with attributes
        $form->attributes = $attributes;
        //validating the form
        if (!$form->validate()) {
            throw new CHttpException(400);
        }

        //getting context of requested model
        list($context, $relation, $relationCount) = $form->getContext();

        if ($context) {
            //getting collection's models from context
            $models = $context->$relation(
                array(
                    'scopes'    => $form->scopes,
                    'limit'     => 1,
                    'condition' => $relation . '.id=:modelId',
                    'params'    => array(
                        'modelId' => $form->getModelId()
                    ),
                )
            );

            //check collection size
            if (!count($models)) {
                throw new CHttpException(404, $this->notFoundMessage);
            }

            //getting model from collection
            $model = array_shift($models);
        } else {
            //getting collection's models from context
            $model = $this->getOwner()->findByPk(
                $form->getModelId(),
                array(
                    'scopes' => $form->scopes
                )
            );

            //check model existence
            if (!count($model)) {
                throw new CHttpException(404, $this->notFoundMessage);
            }
        }

        //saving model to database
        if (!$model->delete() and count($model->getErrors())) {
            //if something is wrong - through an exception
            throw new \ValidationException(406, \Yii::t('error', 'validation'), $model->getErrors());
        }

        //building the model's attributes array
        $modelAttributes = $model->getAttributes();
        //adding model's url
        $modelAttributes['_url'] = $form->getUrl();
        //adding relations data
        $this->addRelations($form->with, $model, $form, $modelAttributes);

        //returning the built model
        return $modelAttributes;
    }

    /**
     *
     */
    public function patchRestModel(array $attributes = array())
    {
        //var_dump(__METHOD__);
    }

    /**
     * @param array $relations
     * @param CActiveRecord $model
     * @param RestFormInterface $form
     * @param array $result
     */
    protected function addRelations(array $relations, CActiveRecord $model, RestFormInterface $form, array &$result)
    {
        //walking through STAT relations
        foreach ($this->filterStatRelations($relations) as $relationName => $relationData) {
            //if relation has no attributes
            if (is_int($relationName)) {
                //just requesting data
                $result[$relationData] = $model->$relationData;
            } else {
                //or requesting data with attributes
                $result[$relationData] = $model->$relationName($relationData);
            }
        }

        //walking through BELONGS_TO relations
        foreach ($this->filterBelongsToRelations($relations) as $relationName => $relationData) {
            //if relation has no attributes
            if (is_int($relationName)) {
                //getting relation information
                $modelRelations = $this->getOwner()->relations();
                $relClass       = $modelRelations[$relationData][1];
                $relParam       = $modelRelations[$relationData][2];

                try {
                    //requesting related model
                    $result[$relationData] = $relClass::model()->readRestModel(
                        array(
                            'company_id'                                               => $form->company_id,
                            $relClass::model()->getRestForm('read')->getModelIdParam() => $model->$relParam
                        )
                    );
                } catch (CHttpException $e) {
                    //if something is wrong - just telling pass null
                    $result[$relationData] = null;
                }
            } else {
                //getting relation information
                $modelRelations = $this->getOwner()->relations();
                $relClass       = $modelRelations[$relationName][1];
                $relParam       = $modelRelations[$relationName][2];

                try {
                    //requesting related model with attributes
                    $relationData['company_id'] = $form->company_id;
                    $relationData[$relParam]    = $model->$relParam;
                    $result[$relationName]      = $relClass::model()->readRestModel($relationData);
                } catch (CHttpException $e) {
                    //if something is wrong - just telling pass null
                    $result[$relationName] = null;
                }
            }
        }

        //walking through HAS_MANY and MANY_MANY relations
        foreach ($this->filterManyRelations($relations) as $relationName => $relationData) {
            //if relation has no attributes
            if (is_int($relationName)) {
                //getting relation information
                $modelRelations = $this->getOwner()->relations();
                $relClass       = $modelRelations[$relationData][1];
                try {
                    //requesting related collection
                    $result[$relationData] = $relClass::model()->readRestCollection(
                        array('company_id' => $form->company_id, $form->getModelIdParam() => $model->id)
                    );
                } catch (CHttpException $e) {
                    //if something is wrong - just telling pass a blank array
                    $result[$relationData] = array();
                }
            } else {
                //getting relation information
                $modelRelations = $this->getOwner()->relations();
                $relClass       = $modelRelations[$relationName][1];
                try {
                    //requesting related collection with attributes
                    $relationData['company_id']             = $form->company_id;
                    $relationData[$form->getModelIdParam()] = $model->id;
                    $result[$relationName]                  = $relClass::model()->readRestCollection($relationData);
                } catch (CHttpException $e) {
                    //if something is wrong - just telling pass a blank array
                    $result[$relationName] = array();
                }
            }
        }

    }

    /**
     * @param array $relations
     * @return array
     */
    protected function filterStatRelations(array $relations)
    {
        $modelRelations    = $this->getOwner()->relations();
        $filteredRelations = array();
        foreach ($relations as $relationName => $relationData) {
            if (is_int($relationName)) {
                $relation = $relationData;
            } else {
                $relation = $relationName;
            }
            foreach ($modelRelations as $modelRelationName => $modelRelationData) {
                if ($relation == $modelRelationName and $modelRelationData[0] == \CActiveRecord::STAT) {
                    $filteredRelations[$relationName] = $relationData;

                }
            }
        }
        return $filteredRelations;
    }

    /**
     * @param array $relations
     * @return array
     */
    protected function filterBelongsToRelations(array $relations)
    {
        $modelRelations    = $this->getOwner()->relations();
        $filteredRelations = array();
        foreach ($relations as $relationName => $relationData) {
            if (is_int($relationName)) {
                $relation = $relationData;
            } else {
                $relation = $relationName;
            }
            foreach ($modelRelations as $modelRelationName => $modelRelationData) {
                if ($relation == $modelRelationName and $modelRelationData[0] == \CActiveRecord::BELONGS_TO) {
                    $filteredRelations[$relationName] = $relationData;

                }
            }
        }
        return $filteredRelations;
    }

    /**
     * @param array $relations
     * @return array
     */
    protected function filterManyRelations(array $relations)
    {
        $modelRelations    = $this->getOwner()->relations();
        $filteredRelations = array();
        foreach ($relations as $relationName => $relationData) {
            if (is_int($relationName)) {
                $relation = $relationData;
            } else {
                $relation = $relationName;
            }
            foreach ($modelRelations as $modelRelationName => $modelRelationData) {
                if (
                    $relation == $modelRelationName and (
                        $modelRelationData[0] == \CActiveRecord::HAS_MANY or
                        $modelRelationData[0] == \CActiveRecord::MANY_MANY
                    )
                ) {
                    $filteredRelations[$relationName] = $relationData;
                }
            }
        }
        return $filteredRelations;
    }
}