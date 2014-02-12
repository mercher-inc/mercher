define(function (require, exports, module) {

    "use strict";

    //requirements
    var _ = require('underscore'),
        Layout = require('backbone.layoutmanager'),
        ItemView = require('views/dialogs/cart/item');

    require('bootstrap');

    return Layout.extend({
        template: _.template(require('text!templates/dialogs/cart.html')),
        tagName: 'div',
        className: 'modal fade view dialogs-cart',

        events: {

        },

        initialize: function (options) {
            this.render();

            /*
            this.listenTo(this.collection, 'all', function(event){
                console.log(event);
            });
            */

            this.listenTo(this.collection, 'add', function (model, collection, options){
                var itemView = new ItemView({model: model});
                this.insertView('.list', itemView);
                itemView.render();
                this.$el.modal({show:true});
            });


            this.listenTo(this.collection, 'add destroy change:amount', function (model, collection, options){
                this.renderSum();
            });
        },

        beforeRender: function () {
            this.collection.each(function (model) {
                this.insertView('.list', new ItemView({model: model}));
            }, this);
        },

        renderSum: function(){
            var sum = 0;
            this.collection.each(function(cartItem){
                var price = parseFloat(cartItem.product.get('amount'));
                var amount = parseInt(cartItem.get('amount'));
                if (isNaN(price)) {
                    price = 0;
                }
                if (isNaN(amount)) {
                    amount = 0;
                }
                price = Math.max(price, 0);
                amount = Math.max(amount, 0);
                sum += price * amount;
            });
            var sumStr = '&#36;';
            sumStr += Math.floor(sum);
            sumStr += '.';
            var dec = String(Math.round((sum % 1) * 100));
            while (dec.length < 2) {
                dec = '0' + dec;
            }
            sumStr += dec;
            this.$('.total-sum').html(sumStr);
        }

    });

});