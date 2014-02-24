<?php
/**
 * Project: mercher
 * Author: Dmitry Les
 * Date: 2/7/14
 * Time: 3:22 PM
 */

namespace PayPalComponent;

use Yii,
    CModel;

abstract class Field extends CModel {

    private $_attributes = [];

    public function __construct($scenario = '')
    {
        $this->setScenario($scenario);
        $this->init();
        $this->attachBehaviors($this->behaviors());
        $this->afterConstruct();
    }

    public function init()
    {
    }

    public function validateField($attribute)
    {
        if ($this->$attribute !== null and !$this->$attribute->validate()) {
            $this->addError($attribute, $this->$attribute->getErrors());
        }
    }

    public function __toArray()
    {
        $data = [];
        foreach ($this->attributes as $attribute=>$value) {
            if ($value instanceof Field) {
                $fieldValue = $value->__toArray();
                if (count($fieldValue)) {
                    $data[$attribute] = $fieldValue;
                }
            } else {
                if ($value !== null) {
                    $data[$attribute] = $value;
                }
            }
        }
        return $data;
    }

    public function __get($name)
    {
        if (isset($this->_attributes[$name]))
            return $this->_attributes[$name];
        elseif (in_array($name, $this->attributeNames())) {
            return null;
        } else
            return parent::__get($name);
    }

    public function __set($name, $value)
    {
        if ($this->setAttribute($name, $value) === false) {
            parent::__set($name, $value);
        }
    }

    public function __isset($name)
    {
        if (isset($this->_attributes[$name]))
            return true;
        elseif (in_array($name, $this->attributeNames()))
            return false; else
            return parent::__isset($name);
    }

    public function __unset($name)
    {
        if (in_array($name, $this->attributeNames()))
            unset($this->_attributes[$name]);
        else
            parent::__unset($name);
    }

    public function hasAttribute($name)
    {
        return in_array($name, $this->attributeNames());
    }

    public function getAttribute($name)
    {
        if (property_exists($this, $name))
            return $this->$name;
        elseif (isset($this->_attributes[$name]))
            return $this->_attributes[$name];
        return false;
    }

    public function setAttribute($name, $value)
    {
        if (property_exists($this, $name))
            $this->$name = $value;
        elseif (in_array($name, $this->attributeNames()))
            $this->_attributes[$name] = $value; else
            return false;
        return true;
    }

    public function getAttributes($names = true)
    {
        $attributes = $this->_attributes;
        foreach ($this->attributeNames() as $name) {
            if (property_exists($this, $name))
                $attributes[$name] = $this->$name;
            elseif ($names === true && !isset($attributes[$name]))
                $attributes[$name] = null;
        }
        if (is_array($names)) {
            $attrs = array();
            foreach ($names as $name) {
                if (property_exists($this, $name))
                    $attrs[$name] = $this->$name;
                else
                    $attrs[$name] = isset($attributes[$name]) ? $attributes[$name] : null;
            }
            return $attrs;
        } else
            return $attributes;
    }

}