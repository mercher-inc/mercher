define(function (require) {

    "use strict";

    var _ = require('underscore'),
        Backbone = require('backbone'),
        shop = require('shop');

    return Backbone.View.extend({

        template: _.template(require('text!tpl/products/list/item.html')),

        className: 'item',

        initialize: function () {
            this.listenTo(this.model, "sync", this.render);
        },

        events: {
            "click .addToCart": "addToCart"
        },

        render: function () {
            this.$el.html(this.template({model: this.model, shop: shop}));
            return this;
        },

        addToCart: function () {
            var obj = {
                "business": shop.get("pp_merchant_id"),
                "item_name": this.model.get('title'),
                "item_number": this.model.id,
                "currency_code": "USD"
            };

            if (this.model.get('amount')) {
                obj.amount = Math.ceil(this.model.get('amount') * 100) / 100;

                if (shop.get("tax")) {
                    obj.tax = Math.ceil(
                        this.model.get('amount') * (shop.get("tax") / 100) * 100
                    ) / 100;
                }
            }

            PAYPAL.apps.MiniCart.addToCart(obj);

            require(['fb'], function (FB) {
                FB.Canvas.scrollTo(0, 0);
            });
        }

    });

});