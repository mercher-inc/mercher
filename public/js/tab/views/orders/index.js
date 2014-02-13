define(function (require, exports, module) {

    "use strict";

    //requirements
    var _ = require('underscore'),
        Layout = require('backbone.layoutmanager'),
        ItemView = require('views/orders/index/item'),
        OrdersCollection = require('collections/orders');

    return Layout.extend({
        collection: new OrdersCollection(),

        template: _.template(require('text!templates/orders/index.html')),
        tagName: 'div',
        className: 'view orders-index',

        events: {
            "click .showMore" : 'showMore'
        },

        initialize: function (options) {
            var view = this;

            this.listenTo(this.collection, 'sync', function (collection, resp, options)  {
                if (collection.count > collection.length) {
                    this.$('.showMore').show();
                } else {
                    this.$('.showMore').hide();
                }
            });

            this.collection.on('add', function (model, collection, options) {
                var itemView = new ItemView({model: model, controller: view.controller});
                view.insertView('.list', itemView);
                itemView.render();
            });
        },

        beforeRender: function () {
            this.collection.each(function (model) {
                this.insertView('.list', new ItemView({model: model, controller: this.controller}));
            }, this);
        },

        showMore: function(){
            this.$('.showMore').button('loading');
            this.listenToOnce(this.collection, 'sync', function(collection, resp, options) {
                this.$('.showMore').button('reset');
            });

            this.collection.offset += this.collection.limit;
            this.collection.fetch({
                data: {
                    limit: this.collection.limit,
                    offset: this.collection.offset
                },
                remove: false
            });

        }

    });

});