define(function (require, exports, module) {

    "use strict";

    //requirements
    var _ = require('underscore'),
        Layout = require('backbone.layoutmanager'),
        ItemView = require('views/orders/index/item/product');

    return Layout.extend({
        template: _.template(require('text!templates/orders/index/item.html')),
        tagName: 'section',
        className: 'view orders-index-item',

        events: {
            'click': 'onClick'
        },

        initialize: function (options) {
            var view = this;

            this.model.items.fetch({data: {limit: -1}});

            this.listenTo(this.model.items, 'add', function(model, collection, options){
                var itemView = new ItemView({model: model, controller: view.controller});
                view.insertView('.products', itemView);
                itemView.render();
            });
        },

        beforeRender: function () {
            this.model.items.each(function (model) {
                this.insertView('.products', new ItemView({model: model, controller: this.controller}));
            }, this);
        },

        serialize: function () {
            var created = new Date(this.model.get('created'));
            var orderDate = created.getMonth() + '/' + created.getDate() + '/' + created.getFullYear();

            var orderStatus = this.model.get('status');
            switch (this.model.get('status')) {
                case 'new':
                    orderStatus = 'New';
                    break;
                case 'waiting_for_payment':
                    orderStatus = 'Waiting for payment';
                    break;
                case 'accented':
                    orderStatus = 'Accented';
                    break;
                case 'rejected':
                    orderStatus = 'Rejected';
                    break;
                case 'approved':
                    orderStatus = 'Approved';
                    break;
                case 'completed':
                    orderStatus = 'Completed';
                    break;
            }

            return { order: this.model, orderDate: orderDate, orderStatus: orderStatus };
        },

        onClick: function(e){
            e.preventDefault();
            this.controller.navigate('/orders/'+this.model.id, {trigger: true});
        }

    });

});