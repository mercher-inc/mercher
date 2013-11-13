<?php
/**
 * Project: mercher
 * Author: Dmitry Les
 * Date: 11/13/13
 * Time: 3:09 PM
 */

class OgController extends CController
{
    public function actionSubscription($subscription_id)
    {
        $subscription = Subscription::model()->findByPk($subscription_id);

        if (!$subscription) {
            throw new CHttpException(404);
        }

        $this->render(
            'subscription',
            [
                'subscription' => $subscription
            ]
        );
    }
}