<?php
/**
 * Created by JetBrains PhpStorm.
 * Project: mercher
 * Author: dmitry
 * Date: 9/9/13
 * Time: 5:22 PM
 */

class ErrorHandler extends CErrorHandler
{
    private $_error;

    public function getError()
    {
        return $this->_error;
    }

    protected function handleException($exception)
    {
        $app = Yii::app();
        if ($app instanceof CWebApplication) {
            if (($trace = $this->getExactTrace($exception)) === null) {
                $fileName  = $exception->getFile();
                $errorLine = $exception->getLine();
            } else {
                $fileName  = $trace['file'];
                $errorLine = $trace['line'];
            }

            $trace = $exception->getTrace();

            foreach ($trace as $i => $t) {
                if (!isset($t['file']))
                {
                    $trace[$i]['file'] = 'unknown';
                }

                if (!isset($t['line']))
                    $trace[$i]['line'] = 0;

                if (!isset($t['function']))
                    $trace[$i]['function'] = 'unknown';

                unset($trace[$i]['object']);
            }

            $this->_error = $data = array(
                'code'      => ($exception instanceof CHttpException) ? $exception->statusCode : 500,
                'type'      => get_class($exception),
                'errorCode' => $exception->getCode(),
                'message'   => $exception->getMessage(),
                'file'      => $fileName,
                'line'      => $errorLine,
                'trace'     => $exception->getTraceAsString(),
                'traces'    => $trace,
            );

            if ($exception instanceof ValidationException) {
                $this->_error['validationErrors'] = $data['validationErrors'] = $exception->validationErrors;
            }

            if (!headers_sent())
                header("HTTP/1.0 {$data['code']} " . $this->getHttpHeader($data['code'], get_class($exception)));

            if ($exception instanceof CHttpException || !YII_DEBUG)
                $this->render('error', $data);
            else {
                if ($this->isAjaxRequest())
                    $app->displayException($exception);
                else
                    $this->render('exception', $data);
            }
        } else
            $app->displayException($exception);
    }
}