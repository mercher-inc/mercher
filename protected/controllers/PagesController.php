<?php
/**
 * Created by JetBrains PhpStorm.
 * Project: mercher
 * Author: dmitry
 * Date: 9/4/13
 * Time: 6:57 PM
 */

class PagesController extends Controller
{
    public function actionIndex()
    {
        $user = User::model()->findByPk(Yii::app()->user->id);

        $pages = array();

        try {
            $pages = Yii::app()->facebook->sdk->api(
                '/' . $user->fb_id . '/accounts?' . http_build_query(array('fields' => 'id', 'limit' => 10))
            );
        } catch (FacebookApiException $e) {
            $pages = $e->getResult();
        }

        if (isset($pages['data']) and count($pages['data'])) {
            $showcasesIds = array();
            foreach ($pages['data'] as $page) {
                $showcasesIds[] = $page['id'];
            }
            //var_dump($showcasesIds);

            $criteria = new CDbCriteria();
            $criteria->addInCondition("fb_id", $showcasesIds);
            $showcases = Showcase::model()->findAll($criteria);
            var_dump($showcases);

        }



        $shops = $user->shops;
        $this->render(
            'index',
            array(
                'shops' => $shops
            )
        );
    }

    public function actionGet()
    {
        $this->render('get');
    }
}