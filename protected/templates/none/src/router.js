define(function (require) {

    "use strict";

    var $ = require('jquery'),
        Backbone = require('backbone'),
        DefaultLayout = require('app/views/layouts/default'),
        CategoriesCollection = require('app/collections/categories'),
        categoriesCollection = new CategoriesCollection(),
        activeView = false,

        $body = $('body'),
        defaultLayout = new DefaultLayout({el: $body, categories: categoriesCollection}).render(),
        $content = $("#content", defaultLayout.el);

    return Backbone.Router.extend({

        routes: {
            "products": "products"
        },

        products: function () {
            require(["app/views/products/list", "app/collections/products", 'app/fb'], function (View, Collection, FB) {

                FB.Canvas.scrollTo(0,0);

                if (activeView) {
                    activeView.setElement(null);
                    activeView.remove();
                }

                var collection = new Collection();

                collection.data.limit = 9;
                activeView = new View({
                    el: $content,
                    collection: collection
                });

                activeView.collection.data.offset = 0;

                activeView.collection.fetch({data: activeView.collection.data});
            });
        }

    });

});