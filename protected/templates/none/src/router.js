define(function (require) {

    "use strict";

    //requirements
    var Backbone = require('backbone'),
        DefaultLayout = require('views/layouts/default');

    return Backbone.Router.extend({

        currentView: null,

        initialize: function () {
            //render layout
            new DefaultLayout({el: 'body'}).render();

            //render minicart
            require(['minicart'], function () {
                paypal.minicart.render({
                    target: '_blank'
                });

                paypal.minicart.cart.on('checkout', function (e) {
                    console.log(e);
                });
            });

            setInterval(function () {
                //getting FB object
                require(['fb'], function (FB) {
                    //get canvas size
                    FB.Canvas.getPageInfo(
                        function (info) {
                            $('#PPMiniCart').css('top', info.scrollTop - info.offsetTop + 200);
                        }
                    );
                });
            }, 500);

            this.on('route', function () {
                if (this.currentView != null) {
                    this.currentView.remove();
                }
            });
        },

        routes: {
            "products": "products",
            "products/:product_id": "product"
        },

        products: function () {
            //load requirements
            require(["views/products/list", "collections/products", 'fb'], function (View, Collection, FB) {
                //setting products collection
                var collection = new Collection();
                collection.data.limit = 9;
                collection.data.offset = 0;

                //setting view
                var view = new View({
                    collection: collection
                });

                //fetching products from server
                view.collection.fetch({data: view.collection.data, reset: true});

                router.currentView = view;
            });
        },

        product: function (product_id) {
            require(["views/products/item", "models/product", 'fb'], function (View, Model, FB) {
                //setting product model
                var model = new Model({id: product_id});

                //setting view
                var view = new View({
                    model: model
                });

                //fetching product from server
                view.model.fetch();

                router.currentView = view;
            });
        }

    });

});