define(function (require) {

    "use strict";

    var Backbone = require('backbone'),
        DefaultLayout = require('app/views/layouts/default');

    return Backbone.Router.extend({

        initialize: function () {
            new DefaultLayout({el: 'body'}).render();

            require(['minicart.min'], function () {
                PAYPAL.apps.MiniCart.render({
                    paypalURL: 'https://www.sandbox.paypal.com/cgi-bin/webscr',
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
            require(['app/ga'], function (ga) {
                ga('send', 'pageview', 'mercher/products');
            });

            require(["app/views/products/list", "app/collections/products", 'app/fb'], function (View, Collection, FB) {

                FB.Canvas.scrollTo(0, 0);

                var collection = new Collection();
                collection.data.limit = 9;
                collection.data.offset = 0;

                var view = new View({
                    collection: collection
                });

                view.collection.fetch({data: view.collection.data, reset: true});
            });
        }

    });

});