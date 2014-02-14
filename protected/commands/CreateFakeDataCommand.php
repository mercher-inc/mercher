<?php
/**
 * Project: mercher2
 * Author: Dmitry Les
 * Date: 2/5/14
 * Time: 12:28 PM
 */

class CreateFakeDataCommand extends CConsoleCommand
{
    const ERROR_USER_NOT_FOUND = 1;
    const ERROR_SHOP_NOT_FOUND = 2;

    public function actionCart($user_id, $shop_id)
    {
        $user = User::model()->findByPk($user_id);

        if (!$user) {
            return self::ERROR_USER_NOT_FOUND;
        }

        $shop = Shop::model()->findByPk($shop_id);

        if (!$shop) {
            return self::ERROR_SHOP_NOT_FOUND;
        }

        $products = $shop->products(
            [
                'order' => 'RANDOM()',
                'limit' => rand(1, 15)
            ]
        );

        foreach ($products as $product) {
            if (
                !CartItem::model()->exists(
                    'product_id = :productId AND user_id = :userId',
                    [
                        'productId' => $product->id,
                        'userId'   => $user->id,
                    ]
                )
            ) {
                $cartItem             = new CartItem();
                $cartItem->product_id = $product->id;
                $cartItem->user_id    = $user->id;
                $cartItem->amount     = rand(1, 10);
                $cartItem->save();
                echo "Product #{$product->id} was added to cart.\n";
            }
        }

        return 0;
    }
}