<?php
/**
 * Project: mercher
 * Author: Dmitry Les
 * Date: 11/12/13
 * Time: 1:00 PM
 */

class LinkPager extends CLinkPager
{

    const CSS_FIRST_PAGE    = false;
    const CSS_LAST_PAGE     = false;
    const CSS_PREVIOUS_PAGE = false;
    const CSS_NEXT_PAGE     = false;
    const CSS_INTERNAL_PAGE = false;
    const CSS_HIDDEN_PAGE   = 'disabled';
    const CSS_SELECTED_PAGE = 'active';

    public $nextPageLabel = '&gt;';
    public $prevPageLabel = '&lt;';
    public $firstPageLabel = '&lt;&lt;';
    public $lastPageLabel = '&gt;&gt;';

    public $header = '';
    public $cssFile = false;
    public $htmlOptions = [
        'class' => 'pagination'
    ];

}