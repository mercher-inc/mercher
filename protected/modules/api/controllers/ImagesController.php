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
            throw new CHttpException(400, 'Image file is required');
        }

        switch ($_FILES['image']['error']) {
            case UPLOAD_ERR_INI_SIZE:
            case UPLOAD_ERR_FORM_SIZE:
                throw new CHttpException(400, 'File is too big');
            case UPLOAD_ERR_PARTIAL:
            case UPLOAD_ERR_NO_FILE:
                throw new CHttpException(400, 'Image file is required');
            case UPLOAD_ERR_NO_TMP_DIR:
            case UPLOAD_ERR_CANT_WRITE:
                throw new CHttpException(500, 'Internal error');
            case UPLOAD_ERR_EXTENSION:
                throw new CHttpException(400, 'This file is not acceptable');
        }

        if ($_FILES['image']['size'] > 1024 * 1024 * 1) {
            throw new CHttpException(400, 'File is too big');
        }

        $path = Yii::getPathOfAlias('webroot.images.shop_' . $shop_id . '.products');
        if (!file_exists($path) or !is_dir($path)) {
            mkdir($path, 0777, true);
        }

        $pathInfo = pathinfo($_FILES['image']['name']);

        $extension = strtolower($pathInfo['extension']);

        if (!in_array($extension, ['jpeg', 'jpg', 'png'])) {
            throw new CHttpException(400, 'This file is not acceptable');
        }

        $name = $pathInfo['filename'];

        $size = getimagesize($_FILES['image']['tmp_name']);

        if ($size[0] > 10000 or $size[1] > 10000) {
            throw new CHttpException(400, 'Image is too large');
        }

        if (!in_array($size[2], [2, 3])) {
            throw new CHttpException(400, 'This file is not acceptable');
        }

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
            throw new CHttpException(400, 'File upload problem');
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

        $sh = clone $i;
        $sh->cropThumbnailImage(111, 74);
        $sh->writeImage($path . DIRECTORY_SEPARATOR . 'sh_' . $filename);

        $image->data = CJSON::encode(
            array(
                'origin' => '/images/shop_' . $shop_id . '/products/' . $filename,
                'xs'     => '/images/shop_' . $shop_id . '/products/' . 'xs_' . $filename,
                's'      => '/images/shop_' . $shop_id . '/products/' . 's_' . $filename,
                'm'      => '/images/shop_' . $shop_id . '/products/' . 'm_' . $filename,
                'l'      => '/images/shop_' . $shop_id . '/products/' . 'l_' . $filename,
                'xl'     => '/images/shop_' . $shop_id . '/products/' . 'xl_' . $filename,
                'sh'     => '/images/shop_' . $shop_id . '/products/' . 'sh_' . $filename,
            )
        );
        $image->save();
        $image->refresh();

        $response         = $image->attributes;
        $response['data'] = CJSON::decode($response['data']);

        echo CJSON::encode($response);
    }
}