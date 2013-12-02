define(function (require) {

    "use strict";

    //requirements
    var _ = require('underscore'),
        Backbone = require('backbone'),
        shop = require('shop');

    return Backbone.View.extend({

        template: _.template(require('text!tpl/products/list/item.html')),

        className: 'item',

        initialize: function () {
            //render view on model update
            this.listenTo(this.model, "sync", this.render);
        },

        events: {
            "click .addToCart": "addToCart"
        },

        render: function () {
            //render product view
            this.$el.html(this.template({model: this.model, shop: shop}));
            //return view
            return this;
        },

        addToCart: function () {
            if (!this.model.get('amount')) {
                return;
            }

            //collecting PayPal object
            var obj = {
                "business": shop.get("pp_merchant_id"),
                "item_name": this.model.get('title'),
                "item_number": this.model.id,
                "amount": Math.ceil(this.model.get('amount') * 100) / 100,
                "currency_code": "USD"
            };

            //calculating tax
            if (shop.get("tax")) {
                obj.tax = Math.ceil(
                    this.model.get('amount') * (shop.get("tax") / 100) * 100
                ) / 100;
            }

            //adding object to cart
            PAYPAL.apps.MiniCart.addToCart(obj);

            //scrolling to top
            require(['fb'], function (FB) {
                FB.Canvas.scrollTo(0, 0);
            });
        }

    });

});