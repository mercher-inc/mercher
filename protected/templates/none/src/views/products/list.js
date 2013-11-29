define(function (require) {

    "use strict";

    var $ = require('jquery'),
        _ = require('underscore'),
        Backbone = require('backbone'),
        tpl = require('text!app/tpl/products/list.html'),
        ProductsListItemView = require('app/views/products/list/item'),
        template = _.template(tpl);

    return Backbone.View.extend({

        initialize: function () {
            this.listenTo(this.collection, "sync", this.render);
        },

        render: function () {
            var view = this;
            require(['app/fb', 'app/ga'], function (FB, ga) {
                ga('send', 'pageview', 'mercher/products');
                view.$el.html(template({collection: view.collection}));

                var $list = $('.list:first', view.$el);
                $list.empty();

                _.each(view.collection.models, function (product, i) {
                    $list.append(new ProductsListItemView({model: product}).render().el);
                }, view);

                var canvasHeight = Math.max(Math.ceil(view.collection.length / 3) * 270, 800);

                FB.Canvas.setSize({height: canvasHeight});

                if (view.collection.data.count - view.collection.length > 0) {
                    var scrollCheckInterval = setInterval(function () {
                        FB.Canvas.getPageInfo(
                            function (info) {
                                if (canvasHeight + info.offsetTop - info.scrollTop <= info.clientHeight) {
                                    clearInterval(scrollCheckInterval);
                                    view.showMore();
                                }
                            }
                        );
                    }, 500);
                }
            });

            return this;
        },

        showMore: function () {
            this.collection.data.offset = this.collection.length;
            this.collection.fetch({
                data: this.collection.data,
                remove: false
            });
        }

    });

});