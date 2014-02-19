define(function (require, exports, module) {

    "use strict";

    //requirements
    var _ = require('underscore'),
        Layout = require('backbone.layoutmanager'),
        amountChangeTimer,
        amountChangeDelay = 500;

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
            var view = this;
            window.clearTimeout(amountChangeTimer);
            amountChangeTimer = window.setTimeout(function(){
                var val = parseInt(view.$('input.amount').val());
                if (isNaN(val)) {
                    val = 0;
                }
                view.model.save({amount: val}, {wait: true});
                view.listenToOnce(view.model, 'error', function(model, resp, options){
                    view.$('input.amount').parent().addClass('has-error');
                    view.stopListening(view.model, 'sync');
                    console.log('error');
                });
                view.listenToOnce(view.model, 'sync', function(model, resp, options){
                    view.$('input.amount').parent().removeClass('has-error');
                    view.stopListening(view.model, 'error');
                    console.log('sync');
                });
            }, amountChangeDelay);
        },

        onBtnDeleteClick: function (e) {
            this.model.destroy({wait: true});
        }

    });

});