define(function (require) {

    "use strict";

    var $ = require('jquery'),
        _ = require('underscore'),
        Backbone = require('backbone'),
        Bootstrap = require('bootstrap'),
        tpl = require('text!app/tpl/products/item.html'),
        template = _.template(tpl);

    return Backbone.View.extend({

        initialize: function () {
            this.listenTo(this.model, "sync", this.render);
        },

        events: {
            "click .addToCart": "addToCart"
        },

        render: function () {
            this.$el.html(template({model: this.model}));
            return this;
        },

        addToCart: function (event) {
            var obj = {
                "business": appConfig.shop.pp_merchant_id,
                "item_name": this.model.get('title'),
                "item_number": this.model.id,
                "currency_code": "USD"
            };

            if (this.model.get('amount')) {
                obj.amount = Math.round(this.model.get('amount') * 100) / 100;
            }

            if (this.model.get('shipping')) {
                obj.shipping = Math.round(this.model.get('shipping') * 100) / 100;
            }

            if (this.model.get('tax')) {
                obj.tax = Math.round(this.model.get('tax') * 100) / 100;
            }

            console.log(event.target);
            console.log(this);

            PAYPAL.apps.MiniCart.addToCart(obj);
        }

    });

});