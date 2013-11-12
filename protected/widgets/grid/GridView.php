<?php
/**
 * Project: mercher
 * Author: Dmitry Les
 * Date: 11/12/13
 * Time: 10:11 AM
 */

Yii::import('zii.widgets.grid.CGridView');
Yii::import('application.widgets.pagers.LinkPager');

class GridView extends CGridView
{
    public $template = "{items}\n{pager}";
    public $selectableRows = 0;
    public $cssFile = false;
    public $pager = ['class' => 'LinkPager'];
    public $pagerCssClass = 'pages';

}