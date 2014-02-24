<?php
/**
 * Created by JetBrains PhpStorm.
 * Project: mercher
 * Author: dmitry
 * Date: 9/9/13
 * Time: 1:13 PM
 */

use \PayPalComponent\Request\ExecutePaymentRequest as ExecutePaymentRequest,
    \PayPalComponent\Response\ExecutePaymentResponse as ExecutePaymentResponse,
    \PayPalComponent\Request\RefundRequest as RefundRequest,
    \PayPalComponent\Response\RefundResponse as RefundResponse,
    \PayPalComponent\Response\PPFaultMessage as PPFaultMessage,
    \PayPalComponent\CurrencyCode as CurrencyCode;

class OrdersController extends Controller
{
    public $layout = '//layouts/shop';

    protected $_shop;

    public function actionIndex($shop_id, $pageSize = 10, $category_id = null)
    {
        $shop = Shop::model()->findByPk($shop_id);
        if (!$shop) {
            throw new CHttpException(
                404,
                Yii::t(
                    'shop',
                    'Shop was not found'
                )
            );
        }

        $user = User::model()->findByPk(Yii::app()->user->id);

        if ($shop->owner_id != $user->id) {
            throw new CHttpException(
                403,
                Yii::t(
                    'shop',
                    'This is not your shop'
                )
            );
        }

        $dataProvider = new CActiveDataProvider(
            'Order',
            [
                'id'            => false,
                'criteria'      => [
                    'condition' => 't.shop_id = :shopId',
                    'params'    => [
                        'shopId' => $shop->id
                    ]
                ],
                'countCriteria' => [
                    'condition' => 't.shop_id = :shopId',
                    'params'    => [
                        'shopId' => $shop->id
                    ]
                ],
                'sort'          => [
                    'defaultOrder' => 'created DESC'
                ],
                'pagination'    => [
                    'pageSize' => (int)$pageSize
                ]
            ]
        );

        $this->render(
            'index',
            array(
                'dataProvider' => $dataProvider
            )
        );
    }

    public function actionGet()
    {
        $this->render('get');
    }


    public function actionApprove($shop_id, $order_id)
    {
        $shop = Shop::model()->findByPk($shop_id);
        if (!$shop) {
            throw new CHttpException(
                404,
                Yii::t(
                    'shop',
                    'Shop was not found'
                )
            );
        }

        $user = User::model()->findByPk(Yii::app()->user->id);

        if ($shop->owner_id != $user->id) {
            throw new CHttpException(
                403,
                Yii::t(
                    'shop',
                    'This is not your shop'
                )
            );
        }

        $order = Order::model()->findByPk($order_id);
        if (!$order or $order->shop_id != $shop->id) {
            throw new CHttpException(
                404,
                Yii::t(
                    'order',
                    'Order was not found'
                )
            );
        }

        if (Yii::app()->request->isPostRequest) {
            $payRequest                               = new ExecutePaymentRequest();
            $payRequest->payKey                       = $order->pay_key;
            $payRequest->requestEnvelope->detailLevel = "ReturnAll";

            if (!$response = $payRequest->submit()) {
                print_r($payRequest);
                throw new CHttpException(500);
            } else {
                if ($response instanceof ExecutePaymentResponse) {
                    if ($response->paymentExecStatus == ExecutePaymentResponse::PAYMENT_EXEC_STATUS_COMPLETED) {
                        $order->status = Order::STATUS_APPROVED;
                        if (!$order->save()) {
                            throw new CHttpException(500);
                        }
                        $this->redirect(['index', 'shop_id' => $order->shop_id]);
                    } elseif ($response->paymentExecStatus == ExecutePaymentResponse::PAYMENT_EXEC_STATUS_ERROR) {
                        throw new CHttpException(500);
                    }
                } elseif ($response instanceof PPFaultMessage) {
                    throw new CHttpException(500, $response->error[0]['message'], $response->error[0]['errorId']);
                } else {
                    throw new CHttpException(500);
                }
            }
        }
        $this->render(
            'approve',
            [
                'model' => $order
            ]
        );
    }

    public function actionReject($shop_id, $order_id)
    {
        $shop = Shop::model()->findByPk($shop_id);
        if (!$shop) {
            throw new CHttpException(
                404,
                Yii::t(
                    'shop',
                    'Shop was not found'
                )
            );
        }

        $user = User::model()->findByPk(Yii::app()->user->id);

        if ($shop->owner_id != $user->id) {
            throw new CHttpException(
                403,
                Yii::t(
                    'shop',
                    'This is not your shop'
                )
            );
        }

        $order = Order::model()->findByPk($order_id);
        if (!$order or $order->shop_id != $shop->id) {
            throw new CHttpException(
                404,
                Yii::t(
                    'order',
                    'Order was not found'
                )
            );
        }

        if (Yii::app()->request->isPostRequest) {
            $refundRequest                               = new RefundRequest();
            $refundRequest->currencyCode                 = CurrencyCode::CURRENCY_CODE_USD;
            $refundRequest->payKey                       = $order->pay_key;
            $refundRequest->requestEnvelope->detailLevel = "ReturnAll";

            if (!$response = $refundRequest->submit()) {
                print_r($refundRequest);
                throw new CHttpException(500);
            } else {
                if ($response instanceof RefundResponse) {
                    $order->status = Order::STATUS_REJECTED;
                    if (!$order->save()) {
                        throw new CHttpException(500);
                    }
                    $this->redirect(['index', 'shop_id' => $order->shop_id]);
                } elseif ($response instanceof PPFaultMessage) {
                    throw new CHttpException(500, $response->error[0]['message'], $response->error[0]['errorId']);
                } else {
                    throw new CHttpException(500);
                }
            }

        }
        $this->render(
            'reject',
            [
                'model' => $order
            ]
        );
    }

    public function actionComplete($shop_id, $order_id)
    {
        $shop = Shop::model()->findByPk($shop_id);
        if (!$shop) {
            throw new CHttpException(
                404,
                Yii::t(
                    'shop',
                    'Shop was not found'
                )
            );
        }

        $user = User::model()->findByPk(Yii::app()->user->id);

        if ($shop->owner_id != $user->id) {
            throw new CHttpException(
                403,
                Yii::t(
                    'shop',
                    'This is not your shop'
                )
            );
        }

        $order = Order::model()->findByPk($order_id);
        if (!$order or $order->shop_id != $shop->id) {
            throw new CHttpException(
                404,
                Yii::t(
                    'order',
                    'Order was not found'
                )
            );
        }

        if (Yii::app()->request->isPostRequest) {
            $order->status = Order::STATUS_COMPLETED;
            if (!$order->save()) {
                throw new CHttpException(500);
            }
            $this->redirect(['index', 'shop_id' => $order->shop_id]);
        }

        $this->render(
            'complete',
            [
                'model' => $order
            ]
        );
    }

    public function getShop()
    {
        if ($this->_shop === null) {
            $this->_shop = Shop::model()->findByPk(Yii::app()->request->getParam('shop_id'));
        }
        return $this->_shop;
    }
}