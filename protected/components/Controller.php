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
	public $layout='//layouts/column1';
	/**
	 * @var array context menu items. This property will be assigned to {@link CMenu::items}.
	 */
	public $menu=array();
	/**
	 * @var array the breadcrumbs of the current page. The value of this property will
	 * be assigned to {@link CBreadcrumbs::links}. Please refer to {@link CBreadcrumbs::links}
	 * for more details on how to specify this property.
	 */
	public $breadcrumbs=array();

    protected function beforeRender($view)
    {
        Yii::app()->clientScript->registerScript(
            'fb_init',
            'FB.init(' . CJSON::encode(
                array(
                    'appId'  => Yii::app()->facebook->sdk->getAppId(),
                    'cookie' => true,
                    'xfbml'  => true,
                    'status' => true,
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

    protected function afterRender($view, &$output)
    {
        //var_dump($_SERVER);
    }
}