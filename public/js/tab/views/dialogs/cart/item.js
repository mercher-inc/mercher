define(function (require, exports, module) {

    "use strict";

    //requirements
    var _ = require('underscore'),
        Layout = require('backbone.layoutmanager');

    return Layout.extend({

        template: _.template(require('text!templates/dialogs/cart/item.html')),
        tagName: 'section',
        className: 'view dialogs-cart-item',

        events: {
            "change .amount": 'onChangeAmount',
            "click .amount": 'onChangeAmount',
            "keyup .amount": 'onChangeAmount',
            "click .btnDelete": 'onBtnDeleteClick'
        },

        initialize: function (options) {
            var view = this;
            this.listenTo(this.model, 'destroy remove', function (model, collection, options){
                this.$el.fadeOut('fast', function(){
                    view.remove();
                });
            });
        },

        serialize: function () {
            return { cart_item: this.model };
        },

        onChangeAmount: function (e) {
            var val = parseInt(this.$('input.amount').val());
            if (isNaN(val)) {
                val = 0;
            }
            val = Math.min(Math.max(val, 0), 1000);
            if (val != parseInt(this.$('input.amount').val())) {
                this.$('input.amount').val(val);
            }
            this.model.set('amount', val);
        },

        onBtnDeleteClick: function (e) {
            this.model.destroy({wait: true});
        }

    });

});