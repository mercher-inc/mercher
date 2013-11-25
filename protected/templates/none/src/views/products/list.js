define(function (require) {

    "use strict";

    var $ = require('jquery'),
        _ = require('underscore'),
        Backbone = require('backbone'),
        Bootstrap = require('bootstrap'),
        tpl = require('text!app/tpl/products/list.html'),
        ProductsListItemView = require('app/views/products/list/item'),
        template = _.template(tpl);

    return Backbone.View.extend({

        initialize: function () {
            this.listenTo(this.collection, "sync", this.render);
        },

        events: {
            "click .showMore": "showMore"
        },

        render: function () {
            ga('send', 'pageview', 'mercher/products');

            this.$el.html(template({collection: this.collection}));

            var $list = $('.list:first', this.$el);
            $list.empty();

            _.each(this.collection.models, function (product, i) {
                $list.append(new ProductsListItemView({model: product}).render().el);
            }, this);

            var canvasHeight = Math.max(Math.ceil(this.collection.length / 3) * 270, 800);

            FB.Canvas.setSize({height: canvasHeight});

            var view = this;

            if (this.collection.data.count - this.collection.length > 0) {
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