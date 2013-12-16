define(function (require) {

    "use strict";

    //requirements
    var _ = require('underscore'),
        Backbone = require('backbone'),
        shop = require('shop');

    //scroll check interval
    var scrollCheckInterval = null;

    return Backbone.View.extend({

        template: _.template(require('text!tpl/products/list.html')),

        className: 'product_list',

        initialize: function () {
            //if collection was reset render view again
            this.listenTo(this.collection, "reset", this.render);
            //if new model was added render product view
            this.listenTo(this.collection, "add", this.renderProduct);
            //stop scroll check
            this.listenTo(this.collection, "request", this.stopScrollCheck);
            //start scroll check
            this.listenTo(this.collection, "sync", this.startScrollCheck);
        },

        render: function (collection, options) {
            var view = this;

            //append to content block
            this.$el.appendTo('#content');

            //render product view
            this.$el.html(this.template({collection: this.collection, shop: shop}));

            //getting FB object
            require(['fb'], function (FB) {
                //scroll top
                FB.Canvas.scrollTo(0, 0);
            });

            //clear list
            $(".list", this.$el).empty();
            //render product views
            _.each(this.collection.models, function (model) {
                this.renderProduct(model);
            }, this);
            //resize canvas
            this.resizeCanvas();

            //track page view
            require(['ga'], function (ga) {
                ga(
                    'send',
                    'pageview',
                    {
                        page: 'products',
                        title: 'Products'
                    }
                );
            });
            //return view
            return this;
        },

        renderProduct: function (model, collection, options) {
            var view = this;
            //get product view module
            require(['views/products/list/item'], function (ProductView) {
                //create product view
                var productView = new ProductView({model: model});
                //render product view
                $(".list", view.$el).append(productView.render().$el);
                //resize canvas
                view.resizeCanvas();
            });
            //return view
            return this;
        },

        calculateHeight: function () {
            return Math.ceil(this.collection.length / 3) * 270 + 50;
        },

        resizeCanvas: function () {
            var view = this;
            //getting FB object
            require(['fb'], function (FB) {
                //setting canvas size
                FB.Canvas.setSize({height: view.calculateHeight()});
            });
        },

        startScrollCheck: function () {
            var view = this;
            var canvasHeight = view.calculateHeight();
            //if there are other models
            if (view.collection.data.count - view.collection.length > 0) {
                //every 0.5 seconds
                this.stopScrollCheck();
                scrollCheckInterval = setInterval(function () {
                    //getting FB object
                    require(['fb'], function (FB) {
                        //get canvas size
                        FB.Canvas.getPageInfo(
                            function (info) {
                                //if bottom edge of canvas is visible
                                if (canvasHeight + info.offsetTop - info.scrollTop <= info.clientHeight) {
                                    //and get more models
                                    view.showMore();
                                }
                            }
                        );
                    });
                }, 500);
            }
        },

        stopScrollCheck: function () {
            //stop checking canvas size
            clearInterval(scrollCheckInterval);
        },

        showMore: function () {
            var view = this;
            //setting offset to request new models
            this.collection.data.offset = this.collection.length;
            //fetching new models from server
            this.collection.fetch({
                data: this.collection.data,
                remove: false
            });
            //track showMore event
            require(['ga'], function (ga) {
                ga(
                    'send',
                    'event',
                    'products',
                    'showMore',
                    'Show more products'
                );
            });
        }

    });

});