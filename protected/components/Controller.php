<?php
/**
 * Controller is the customized base controller class.
 * All controller classes for this application should extend from this base class.
 */
class Controller extends CController
{
    /**
     * @var string the default layout for the controller view. Defaults to '//layouts/column1',
     * meaning using a single column layout. See 'protected/views/layouts/column1.php'.
     */
    public $layout = '//layouts/default';
    /**
     * @var array context menu items. This property will be assigned to {@link CMenu::items}.
     */
    public $menu = array();
    /**
     * @var array context menu items. This property will be assigned to {@link CMenu::items}.
     */
    public $shopsMenu = array();

    /**
     * @var string title to display in header
     */
    public $headerTitle;

    /**
     * @var array urls to display in header
     */
    public $headerButtons = array();

    /**
     * @var array table headings to display in header
     */
    public $headerTable = array();

    /**
     * @var array body tag's html options
     */
    public $bodyHtmlOptions = array(
        'id'    => 'layout-default',
        'class' => ''
    );

    /**
     * @var array the breadcrumbs of the current page. The value of this property will
     * be assigned to {@link CBreadcrumbs::links}. Please refer to {@link CBreadcrumbs::links}
     * for more details on how to specify this property.
     */
    public $breadcrumbs = array();

    protected function beforeAction($action)
    {
        if (!parent::beforeAction($action)) {
            return false;
        }

        Yii::app()->clientScript->registerScript(
            'fb_init',
            'FB.init(' . CJSON::encode(
                array(
                    'appId'      => Yii::app()->facebook->sdk->getAppId(),
                    'cookie'     => true,
                    'xfbml'      => true,
                    'status'     => true,
                    'channelUrl' => Yii::app()->urlManager->baseUrl . '/channel.html',
                )
            ) . ');',
            ClientScript::POS_FB
        );

        Yii::app()->clientScript->registerScript(
            'fb_load_the_SDK_asynchronously',
            '(function(d, s, id){' .
                'var js, fjs = d.getElementsByTagName(s)[0];' .
                'if (d.getElementById(id)) {return;}' .
                'js = d.createElement(s); js.id = id;' .
                'js.src = "//connect.facebook.net/en_US/all.js";' .
                'fjs.parentNode.insertBefore(js, fjs);' .
                '}(document, \'script\', \'facebook-jssdk\'));',
            ClientScript::POS_END
        );

        Yii::app()->clientScript->registerScript(
            'fb_app_id',
            'var fb_app_id = ' . CJSON::encode(Yii::app()->facebook->sdk->getAppId()) . ';',
            ClientScript::POS_END
        );

        return true;
    }

    protected function beforeRender($view)
    {
        Yii::app()->clientScript->registerMetaTag('text/html; charset=UTF-8', null, 'Content-Type');
        Yii::app()->clientScript->registerMetaTag(
            'width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no',
            'viewport'
        );
        Yii::app()->clientScript->registerMetaTag('en', 'language');

        Yii::app()->clientScript->registerScript(
            'appIframeCheck',
            '
                if (location.hostname.match(/^app./)) {
                    if (self == top) {
                        top.location.replace(location.href.replace(/^(http|https):\/\/(app.)/, "http://"));
                    }
                }
            '
        );

        Yii::app()->clientScript->registerCssFile('/css/style.css');

        if (!Yii::app()->user->isGuest) {
            $user = User::model()->findByPk(Yii::app()->user->id);
            if (count($user->shops)) {
                foreach ($user->shops as $shop) {
                    $this->shopsMenu[] = [
                        'label'       => $shop->title,
                        'url'         => ['products/index', 'shop_id' => $shop->id],
                        'linkOptions' => [
                            'class'        => 'pageProfile',
                            'data-page-id' => $shop->fb_id,
                            'style'        => 'background-image: url("https://graph.facebook.com/' . $shop->fb_id . '/picture?type=square");'
                        ],
                        'active'    => (isset($this->shop) and $this->shop->id == $shop->id)?true:false
                    ];
                }
                /*
                $this->shopsMenu[] = [
                    'itemOptions' => [
                        'class' => 'divider'
                    ]
                ];
                */
            }
            if (count($user->managedShops)) {
                foreach ($user->managedShops as $shop) {
                    $this->shopsMenu[] = [
                        'label'       => $shop->title,
                        'url'         => ['products/index', 'shop_id' => $shop->id],
                        'linkOptions' => [
                            'class'        => 'pageProfile',
                            'data-page-id' => $shop->fb_id,
                            'style'        => 'background-image: url("https://graph.facebook.com/' . $shop->fb_id . '/picture?type=square");'
                        ],
                        'active'    => (isset($this->shop) and $this->shop->id == $shop->id)?true:false
                    ];
                }
                /*
                $this->shopsMenu[] = [
                    'itemOptions' => [
                        'class' => 'divider'
                    ]
                ];
                */
            }
            Yii::app()->clientScript->registerScript(
                'pageProfile',
                '
                    $(".pageProfile").each(function(){
                        var pageProfile = this;
                        FB.api(
                            $(pageProfile).attr("data-page-id"),
                            function(response) {
                                if (response.name) {
                                    $(pageProfile).html(response.name);
                                }
                            }
                        );
                    });
                ',
                ClientScript::POS_FB
            );
        }

        return true;
    }

    protected function afterRender($view, &$output)
    {
        //var_dump($_SERVER);
    }
}