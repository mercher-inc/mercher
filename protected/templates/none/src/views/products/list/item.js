define(function (require) {

    "use strict";

    var _ = require('underscore'),
        Backbone = require('backbone');

    return Backbone.View.extend({
        template: _.template(require('text!app/tpl/products/list/item.html')),

        className: 'item',

        initialize: function () {
            this.listenTo(this.model, "sync", this.render);
        },

        events: {
            "click .addToCart": "addToCart"
        },

        render: function () {
            this.$el.html(this.template({model: this.model}));
            return this;
        },

        addToCart: function () {
            var obj = {
                "business": appConfig.shop.pp_merchant_id,
                "item_name": this.model.get('title'),
                "item_number": this.model.id,
                "currency_code": "USD"
            };

            if (this.model.get('amount')) {
                obj.amount = Math.ceil(this.model.get('amount') * 100) / 100;

                if (appConfig.shop.tax) {
                    obj.tax = Math.ceil(
                        this.model.get('amount') * (appConfig.shop.tax / 100) * 100
                    ) / 100;
                }
            }

            PAYPAL.apps.MiniCart.addToCart(obj);
        }

    });

});