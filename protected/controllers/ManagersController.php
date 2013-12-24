<?php
/**
 * Project: mercher
 * Author: Dmitry Les
 * Date: 12/23/13
 * Time: 7:32 PM
 */

class ManagersController extends Controller
{
    public $layout = '//layouts/shop';

    protected $_shop;
    protected $_manager;

    public function filters()
    {
        return array(
            'accessControl',
        );
    }

    public function accessRules()
    {
        return array(
            array(
                'allow',
                'actions' => array('index'),
                'roles'   => array(
                    AuthManager::PERMISSION_READ_MANAGER => array(
                        'shop_id' => Yii::app()->request->getParam('shop_id'),
                    )
                )
            ),
            array(
                'allow',
                'actions' => array('create'),
                'roles'   => array(
                    AuthManager::PERMISSION_CREATE_MANAGER => array(
                        'shop_id' => Yii::app()->request->getParam('shop_id')
                    )
                )
            ),
            array(
                'allow',
                'actions' => array('read'),
                'roles'   => array(
                    AuthManager::PERMISSION_READ_MANAGER => array(
                        'shop_id' => Yii::app()->request->getParam('shop_id'),
                        'user_id' => Yii::app()->request->getParam('user_id'),
                    )
                )
            ),
            array(
                'allow',
                'actions' => array('update'),
                'roles'   => array(
                    AuthManager::PERMISSION_UPDATE_MANAGER => array(
                        'shop_id' => Yii::app()->request->getParam('shop_id'),
                        'user_id' => Yii::app()->request->getParam('user_id'),
                    )
                )
            ),
            array(
                'allow',
                'actions' => array('delete'),
                'roles'   => array(
                    AuthManager::PERMISSION_DELETE_MANAGER => array(
                        'shop_id' => Yii::app()->request->getParam('shop_id'),
                        'user_id' => Yii::app()->request->getParam('user_id'),
                    )
                )
            ),
            array(
                'deny',
                'users' => array('*'),
            ),
        );
    }

    public function actionIndex()
    {
        $model = new Manager('search');
        $model->unsetAttributes();

        if (isset($_GET['Manager'])) {
            $model->attributes = $_GET['Manager'];
        }
        $model->shop_id = $this->shop->id;

        $this->render(
            'index',
            array(
                'model' => $model,
            )
        );
    }

    public function actionCreate()
    {
        $this->manager = new Manager();

        if (isset($_POST['Manager'])) {
            $this->manager->attributes = $_POST['Manager'];
            $this->manager->shop_id    = $this->shop->id;

            if ($this->manager->save()) {
                $this->redirect(['index', 'shop_id' => $this->shop->id]);
            }
        }

        try {
            $accessToken = Yii::app()->facebook->sdk->api(
                $this->shop->fb_id . '?' . http_build_query(['fields' => 'access_token'])
            );
        } catch (FacebookApiException $e) {
            throw new CHttpException(500, $e->getMessage());
        }

        if (!isset($accessToken['access_token'])) {
            throw new CHttpException(500, 'Internal error');
        } else {
            $pageAccessToken = $accessToken['access_token'];
        }

        $userAccessToken = Yii::app()->facebook->sdk->getAccessToken();
        Yii::app()->facebook->sdk->setAccessToken($pageAccessToken);

        try {
            $admins = Yii::app()->facebook->sdk->api(
                $this->shop->fb_id . '?' . http_build_query(
                    [
                        'fields' => 'admins.limit(50)',
                    ]
                )
            );
        } catch (FacebookApiException $e) {
            throw new CHttpException(500, $e->getMessage());
        }
        Yii::app()->facebook->sdk->setAccessToken($userAccessToken);

        $adminsList = [];

        $owner = User::model()->findByPk(Yii::app()->user->id);

        if (isset($admins['admins']) and isset($admins['data'])) {
            foreach ($admins['admins']['data'] as $admin) {
                if ($admin['id'] == $owner->fb_id) {
                    continue;
                }
                if (
                    Yii::app()->db->createCommand()
                        ->select("COUNT(m.*) > 0 AS check")
                        ->from(Manager::model()->tableName() . ' AS m')
                        ->join(
                            User::model()->tableName() . ' AS u',
                            'm.user_id = u.id'
                        )
                        ->where(
                            "u.fb_id = :userId AND m.shop_id = :shopId",
                            [
                                ":shopId" => $this->shop->id,
                                ":userId" => $admin['id'],
                            ]
                        )
                        ->queryScalar()
                ) {
                    continue;
                }
                $user = User::model()->findByAttributes(
                    [
                        'fb_id' => $admin['id']
                    ]
                );
                if (!$user) {
                    try {
                        $newAdmin = Yii::app()->facebook->sdk->api(
                            $admin['id']
                        );
                    } catch (FacebookApiException $e) {
                        throw new CHttpException(500, $e->getMessage());
                    }
                    $user             = new User();
                    $user->fb_id      = $newAdmin['id'];
                    $user->first_name = $newAdmin['first_name'];
                    $user->last_name  = $newAdmin['last_name'];
                    if (isset($newAdmin['username'])) {
                        $user->email = $newAdmin['username'] . '@facebook.com';
                    } else {
                        $user->email = $newAdmin['id'] . '@facebook.com';
                    }
                    $user->save();
                }
                $adminsList[$user->id] = $user->name;
            }
        }


        $this->render(
            'create',
            array(
                'shop'       => $this->shop,
                'model'      => $this->manager,
                'adminsList' => $adminsList
            )
        );
    }

    public function actionUpdate()
    {
        if (isset($_POST['Manager'])) {
            $this->manager->attributes = $_POST['Manager'];

            if ($this->manager->save()) {
                $this->redirect(['index', 'shop_id' => $this->shop->id]);
            }
        }

        $this->render(
            'update',
            array(
                'shop'  => $this->shop,
                'model' => $this->manager
            )
        );
    }

    public function actionDelete()
    {
        if (Yii::app()->request->isDeleteRequest) {
            $this->manager->delete();
            $this->redirect(['index', 'shop_id' => $this->shop->id]);
        }
        $this->render(
            'delete',
            array(
                'shop'  => $this->shop,
                'model' => $this->manager
            )
        );
    }

    public function getShop()
    {
        if (!$this->_shop) {
            $this->_shop = Shop::model()->findByPk(Yii::app()->request->getParam('shop_id'));
            if (!$this->_shop) {
                throw new CHttpException(404);
            }
        }
        return $this->_shop;
    }

    public function getManager()
    {
        if (!$this->_manager) {
            $this->_manager = Manager::model()->findByAttributes(
                [
                    'shop_id' => Yii::app()->request->getParam('shop_id'),
                    'user_id' => Yii::app()->request->getParam('user_id'),
                ]
            );
            if (!$this->_manager) {
                throw new CHttpException(404);
            }
        }
        return $this->_manager;
    }

    public function setManager(Manager $manager)
    {
        $this->_manager = $manager;
    }
}