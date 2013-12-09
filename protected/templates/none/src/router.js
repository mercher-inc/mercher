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
                paypal.minicart.render({
                    action: 'https://www.sandbox.paypal.com/cgi-bin/webscr',
                    target: '_blank'
                });

                paypal.minicart.cart.on('checkout', function(e){
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