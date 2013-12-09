define(function (require) {

    "use strict";

    //requirements
    var Backbone = require('backbone'),
        DefaultLayout = require('views/layouts/default');

    return Backbone.Router.extend({

        initialize: function () {
            //render layout
            new DefaultLayout({el: 'body'}).render();

            //render minicart
            require(['minicart'], function () {
                PAYPAL.apps.MiniCart.render({
                    //paypalURL: 'https://www.sandbox.paypal.com/cgi-bin/webscr',
                    parent: 'PayPalCart',
                    formTarget: '_blank',
                    edgeDistance: '15px',
                    strings: {
                        subtotal: 'Subtotal: ',
                        shipping: 'Does not include shipping',
                        button: 'Checkout',
                        processing: 'Checkout'
                    }
                });
            });

        },

        routes: {
            "products": "products"
        },

        products: function () {
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

            //load requirements
            require(["views/products/list", "collections/products", 'fb'], function (View, Collection, FB) {

                //scroll top
                FB.Canvas.scrollTo(0, 0);

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
            });
        }

    });

});