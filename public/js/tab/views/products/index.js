define(function (require, exports, module) {

    "use strict";

    //requirements
    var _ = require('underscore'),
        Layout = require('backbone.layoutmanager'),
        ItemView = require('views/products/index/item'),
        ProductsCollection = require('collections/products');

    require('bootstrap');

    return Layout.extend({
        collection: new ProductsCollection(),

        template: _.template(require('text!templates/products/index.html')),
        tagName: 'div',
        className: 'view products-index',

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

                if (view.collection.count > view.collection.length) {
                    view.$('.showMore').show();
                } else {
                    view.$('.showMore').hide();
                }

                itemView.$el.hide();
                itemView.render();

                var shortestCol = 0;
                for (var i in view.cols) {
                    if ($(view.cols[i]).innerHeight() < $(view.cols[shortestCol]).innerHeight()) {
                        shortestCol = i;
                    }
                }
                itemView.$el.appendTo(view.cols[shortestCol]);
                itemView.$el.fadeIn('slow');
                itemView.$('.image img').css('height', itemView.$('.image img').width());
                itemView.$('.image img').one('load', function(e){
                    $(e.target).css('height', 'auto');
                });
            });
        },

        beforeRender: function () {
            var view = this;
            this.collection.each(function (model) {
                this.insertView('.list', new ItemView({model: model, controller: view.controller}));
            }, this);
        },

        afterRender: function () {
            this.moveCards(true);
            if (this.collection.count > this.collection.length) {
                this.$('.showMore').show();
            } else {
                this.$('.showMore').hide();
            }
        },

        moveCards: function (force) {
            var view = this,
                i,
                row,
                colsCount = 2;

            if (force || this.cols.length != colsCount) {
                row = this.$('.list>.row');
                if (!row.length) {
                    row = $('<div class="row"></div>');
                    row.appendTo(this.$('.list'));
                }
                row.empty();

                this.cols = [];

                for (i = 0; i < colsCount; i++) {
                    this.cols[i] = $('<div></div>');
                    this.cols[i].addClass('col-xs-6');
                    this.cols[i].addClass('col_'+(i+1));
                    this.cols[i].appendTo(row);
                }

                this.getViews('.list').each(function (itemView) {
                    var shortestCol = 0;
                    for (i in view.cols) {
                        if ($(view.cols[i]).innerHeight() < $(view.cols[shortestCol]).innerHeight()) {
                            shortestCol = i;
                        }
                    }
                    itemView.$el.appendTo(view.cols[shortestCol]);
                    itemView.$('.image img').css('height', itemView.$('.image img').width());
                    itemView.$('.image img').one('load', function(e){
                        $(e.target).css('height', 'auto');
                    });
                });
            }
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