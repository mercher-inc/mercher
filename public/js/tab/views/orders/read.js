define(function (require, exports, module) {

    "use strict";

    //requirements
    var _ = require('underscore'),
        Layout = require('backbone.layoutmanager'),
        ItemView = require('views/orders/read/item');

    return Layout.extend({
        template: _.template(require('text!templates/orders/read.html')),
        tagName: 'div',
        className: 'view orders-read',

        events: {
            "click .showMore" : 'showMore'
        },

        initialize: function (options) {
            var view = this;

            this.model.items.fetch();

            this.listenTo(this.model.items, 'sync', function (collection, resp, options)  {
                if (collection.count > collection.length) {
                    this.$('.showMore').show();
                } else {
                    this.$('.showMore').hide();
                }
            });

            this.listenTo(this.model.items, 'add', function(model, collection, options){
                var itemView = new ItemView({model: model, controller: view.controller});
                view.insertView('.order-items .list', itemView);
                itemView.render();
            });
        },

        beforeRender: function () {
            this.removeView('.order-items .list');
            this.model.items.each(function (model) {
                this.insertView('.order-items .list', new ItemView({model: model, controller: this.controller}));
            }, this);
        },

        afterRender: function() {
            if (this.model.items.count > this.model.items.length) {
                this.$('.showMore').show();
            } else {
                this.$('.showMore').hide();
            }
        },

        serialize: function () {
            return { order: this.model };
        },

        showMore: function(){
            this.$('.showMore').button('loading');
            this.listenToOnce(this.model.items, 'sync', function(collection, resp, options) {
                this.$('.showMore').button('reset');
            });

            this.model.items.offset += this.model.items.limit;
            this.model.items.fetch({
                data: {
                    limit: this.model.items.limit,
                    offset: this.model.items.offset
                },
                remove: false
            });

        }

    });

});