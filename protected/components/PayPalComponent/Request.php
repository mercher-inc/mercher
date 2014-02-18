<?php
/**
 * Project: mercher
 * Author: Dmitry Les
 * Date: 2/7/14
 * Time: 1:16 PM
 */

namespace PayPalComponent;

use Yii,
    CModel;

abstract class Request extends CModel
{
    public static $client;

    public $authHeader;

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
        foreach ($this->attributes as $attribute => $value) {
            if ($value instanceof Field) {
                $data[$attribute] = $value->__toArray();
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
        if (isset($this->_attributes[$name])) {
            return $this->_attributes[$name];
        } elseif (in_array($name, $this->attributeNames())) {
            return null;
        } else {
            return parent::__get($name);
        }
    }

    public function __set($name, $value)
    {
        if ($this->setAttribute($name, $value) === false) {
            parent::__set($name, $value);
        }
    }

    public function __isset($name)
    {
        if (isset($this->_attributes[$name])) {
            return true;
        } elseif (in_array($name, $this->attributeNames())) {
            return false;
        } else {
            return parent::__isset($name);
        }
    }

    public function __unset($name)
    {
        if (in_array($name, $this->attributeNames())) {
            unset($this->_attributes[$name]);
        } else {
            parent::__unset($name);
        }
    }

    abstract public function endpoint();

    public function getClient()
    {
        if (self::$client !== null) {
            return self::$client;
        } else {
            self::$client = Yii::app()->paypal;
            if (self::$client instanceof \PayPalComponent\Client) {
                return self::$client;
            } else {
                throw new Exception(Yii::t(
                    'yii',
                    'Request requires a "paypal" \PayPalComponent\Client application component.'
                ));
            }
        }
    }

    public function hasAttribute($name)
    {
        return in_array($name, $this->attributeNames());
    }

    public function getAttribute($name)
    {
        if (property_exists($this, $name)) {
            return $this->$name;
        } elseif (isset($this->_attributes[$name])) {
            return $this->_attributes[$name];
        }
        return false;
    }

    public function setAttribute($name, $value)
    {
        if (property_exists($this, $name)) {
            $this->$name = $value;
        } elseif (in_array($name, $this->attributeNames())) {
            $this->_attributes[$name] = $value;
        } else {
            return false;
        }
        return true;
    }

    public function getAttributes($names = true)
    {
        $attributes = $this->_attributes;
        foreach ($this->attributeNames() as $name) {
            if (property_exists($this, $name)) {
                $attributes[$name] = $this->$name;
            } elseif ($names === true && !isset($attributes[$name])) {
                $attributes[$name] = null;
            }
        }
        if (is_array($names)) {
            $attrs = array();
            foreach ($names as $name) {
                if (property_exists($this, $name)) {
                    $attrs[$name] = $this->$name;
                } else {
                    $attrs[$name] = isset($attributes[$name]) ? $attributes[$name] : null;
                }
            }
            return $attrs;
        } else {
            return $attributes;
        }
    }

    abstract protected function parseResponse($response);

    public function submit($runValidation = true, $attributes = null)
    {
        if (!$runValidation || $this->validate($attributes)) {
            if ($this->beforeSubmit()) {
                return $this->parseResponse($this->getClient()->submitRequest($this));
            }
            return false;
        } else {
            return false;
        }
    }

    public function onBeforeSubmit($event)
    {
        $this->raiseEvent('onBeforeSubmit', $event);
    }

    public function onAfterSubmit($event)
    {
        $this->raiseEvent('onAfterSubmit', $event);
    }

    protected function beforeSubmit()
    {
        if ($this->hasEventHandler('onBeforeSubmit')) {
            $event = new \CModelEvent($this);
            $this->onBeforeSubmit($event);
            return $event->isValid;
        } else {
            return true;
        }
    }

    protected function afterSubmit()
    {
        if ($this->hasEventHandler('onAfterSubmit')) {
            $this->onAfterSubmit(new \CEvent($this));
        }
    }


}