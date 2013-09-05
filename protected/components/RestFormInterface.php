<?php
/**
 * Created by JetBrains PhpStorm.
 * Project: rallyware
 * Author: dmitry
 * Date: 8/20/13
 * Time: 12:25 PM
 */

interface RestFormInterface
{
    public function getModelIdParam();

    public function getModelId();

    public function getUrl();

    public function getContext();
}