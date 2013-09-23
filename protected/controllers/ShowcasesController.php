<?php
/**
 * Created by JetBrains PhpStorm.
 * Project: mercher
 * Author: dmitry
 * Date: 9/4/13
 * Time: 6:57 PM
 */

class ShowcasesController extends Controller
{
    protected $_showcase;

    public function actionIndex()
    {
        $user = User::model()->findByPk(Yii::app()->user->id);

        $url   = '/' . $user->fb_id . '/accounts?' . http_build_query(
            array('fields' => 'id,name,description', 'limit' => 10)
        );

        $pages = Yii::app()->cache->get($url);

        if ($pages === false) {
            try {
                $pages = Yii::app()->facebook->sdk->api($url);
                if (isset($pages['data']) and count($pages['data'])) {
                    Yii::app()->cache->set($url, $pages, 60*5);
                }
            } catch (FacebookApiException $e) {
                $pages = $e->getResult();
            }
        }

        if (isset($pages['data']) and count($pages['data'])) {

            $showcasesIds = array();
            foreach ($pages['data'] as $page) {
                $showcasesIds[] = $page['id'];
            }

            $criteria = new CDbCriteria();
            $criteria->addInCondition("fb_id", $showcasesIds);
            $showcases = Showcase::model()->findAll($criteria);

            foreach ($pages['data'] as $page) {
                foreach ($showcases as $showcase) {
                    if ($page['id'] == $showcase->fb_id) {
                        continue 2;
                    }
                }

                $showcase        = new Showcase();
                $showcase->fb_id = $page['id'];
                if (isset($page['name'])) {
                    $showcase->title = $page['name'];
                }
                if (isset($page['description'])) {
                    $showcase->description = $page['description'];
                }
                $showcase->is_active = false;
                $showcases[]         = $showcase;
            }
        } else {
            $showcases = array();
        }

        $this->render(
            'index',
            array(
                'showcases' => $showcases
            )
        );
    }

    public function actionGet()
    {
        $this->layout = '//layouts/showcase';
        $this->render(
            'get',
            array(
                'showcase' => $this->showcase
            )
        );
    }

    public function getShowcase() {
        if (!$this->_showcase) {
            $this->_showcase = Showcase::model()->findByPk(Yii::app()->request->getParam('showcase_id'));
            if (!$this->_showcase) {
                throw new CHttpException(404);
            }

            $user = User::model()->findByPk(Yii::app()->user->id);
            $url   = '/' . $this->_showcase->fb_id . '?' . http_build_query(
                array('fields' => 'id,name,description')
            );
            $page = Yii::app()->cache->get('/' . $user->fb_id . $url);
            if ($page === false) {
                try {
                    $page = Yii::app()->facebook->sdk->api($url);
                    if (isset($page['error'])) {
                        throw new CHttpException(401);
                    }
                    Yii::app()->cache->set('/' . $user->fb_id . $url, $page, 60*5);
                } catch (FacebookApiException $e) {
                    throw new CHttpException(401);
                }
            }
        }
        return $this->_showcase;
    }
}