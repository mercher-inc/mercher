<?php
/**
 * Created by JetBrains PhpStorm.
 * Project: mercher
 * Author: dmitry
 * Date: 9/9/13
 * Time: 11:47 AM
 */

class ValidationException extends CHttpException
{
    public $validationErrors = array();

    public function __construct($status, $message = null, $validationErrors, $code = 0)
    {
        $this->validationErrors = $validationErrors;
        parent::__construct($status, $message, $code);
    }
}