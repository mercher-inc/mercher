<?php
/**
 * Project: mercher
 * Author: Dmitry Les
 * Date: 12/2/13
 * Time: 1:27 PM
 */

namespace api\controllers;

use Image,
    Imagick,
    Yii,
    CHttpException,
    CController,
    CJSON;

class ImagesController extends CController
{
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
                'actions' => array(
                    'upload',
                ),
                'users'   => array('@'),
            ),
            array(
                'deny',
                'users' => array('*'),
            ),
        );
    }

    public function actionUpload($shop_id)
    {
        if (!isset($_FILES['image'])) {
            throw new CHttpException(406, 'No file');
        }

        $path = Yii::getPathOfAlias('webroot.images.shop_' . $shop_id . '.products');
        if (!file_exists($path) or !is_dir($path)) {
            mkdir($path, 0777, true);
        }

        $pathInfo = pathinfo($_FILES['image']['name']);

        $extension = $pathInfo['extension'];
        $name = $pathInfo['filename'];

        $filename = md5(
            $name
        ) . ($extension ? ('.' . $extension) : '');
        while (Image::model()->exists(
            'original_file = :originalFile',
            array('originalFile' => $path . DIRECTORY_SEPARATOR . $filename)
        )) {
            $filename = md5(
                $filename . time()
            ) . ($extension ? ('.' . $extension) : '');
        }

        if (!move_uploaded_file($_FILES['image']['tmp_name'], $path . DIRECTORY_SEPARATOR . $filename)) {
            throw new CHttpException(406, 'Possible file upload attack!');
        }

        $image                = new Image();
        $image->shop_id       = $shop_id;
        $image->original_file = $path . DIRECTORY_SEPARATOR . $filename;

        $i = new Imagick($image->original_file);

        $xs = clone $i;
        $xs->cropThumbnailImage(50, 50);
        $xs->writeImage($path . DIRECTORY_SEPARATOR . 'xs_' . $filename);

        $s = clone $i;
        $s->cropThumbnailImage(100, 100);
        $s->writeImage($path . DIRECTORY_SEPARATOR . 's_' . $filename);

        $m = clone $i;
        $m->cropThumbnailImage(200, 200);
        $m->writeImage($path . DIRECTORY_SEPARATOR . 'm_' . $filename);

        $l = clone $i;
        $l->cropThumbnailImage(400, 400);
        $l->writeImage($path . DIRECTORY_SEPARATOR . 'l_' . $filename);

        $xl = clone $i;
        $xl->cropThumbnailImage(800, 800);
        $xl->writeImage($path . DIRECTORY_SEPARATOR . 'xl_' . $filename);

        $image->data = CJSON::encode(
            array(
                'origin' => '/images/shop_' . $shop_id . '/products/' . $filename,
                'xs'     => '/images/shop_' . $shop_id . '/products/' . 'xs_' . $filename,
                's'      => '/images/shop_' . $shop_id . '/products/' . 's_' . $filename,
                'm'      => '/images/shop_' . $shop_id . '/products/' . 'm_' . $filename,
                'l'      => '/images/shop_' . $shop_id . '/products/' . 'l_' . $filename,
                'xl'     => '/images/shop_' . $shop_id . '/products/' . 'xl_' . $filename,

            )
        );
        $image->save();
        $image->refresh();

        $response = $image->attributes;
        $response['data'] = CJSON::decode($response['data']);

        echo CJSON::encode($response);
    }
}