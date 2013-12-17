define(function (require) {

    "use strict";

    //requirements
    var _ = require('underscore'),
        Backbone = require('backbone'),
        shop = require('shop');

    return Backbone.View.extend({

        template: _.template(require('text!tpl/products/item.html')),

        className: 'product_item',

        initialize: function () {
            //if collection was reset render view again
            this.listenTo(this.model, "sync", this.render);
        },

        events: {
            "click .addToCart": "addToCart",
            "click .likeBtn": "likeProduct",
            "click .addBtn": "addProduct",
            "click .back": "goToProducts"
        },

        render: function (model, options) {
            var view = this;
            var showShareBtn = false;

            //append to content block
            this.$el.appendTo('#content');

            //render product view
            this.$el.html(this.template({model: this.model, shop: shop}));



            //getting FB object
            require(['fb'], function (FB) {
                //setting canvas size
                FB.Canvas.setSize({height: 810});
                //scroll top
                FB.Canvas.scrollTo(0, 0);

                FB.XFBML.parse(view.el);
            });

            //track page view
            require(['ga'], function (ga) {
                ga(
                    'send',
                    'pageview',
                    {
                        page: 'products/' + view.model.id,
                        title: view.model.get('title')
                    }
                );
            });
            //return view
            return this;
        },

        addToCart: function (e) {
            var view = this;
            if (!this.model.get('amount')) {
                return;
            }

            //collecting PayPal object
            var obj = {
                "business": shop.get("pp_merchant_id"),
                "item_name": this.model.get('title'),
                "item_number": this.model.id,
                "amount": Math.ceil((this.model.get('amount') / (100 - shop.get("tax"))) * (100 + shop.get("tax")) * 100) / 100,
                "currency_code": "USD"
            };

            //adding object to cart
            require(['minicart'], function () {
                paypal.minicart.cart.add(obj);
            });
        },

        likeProduct: function (e) {
            var view = this;
            //getting FB object
            require(['fb'], function (FB) {
                FB.getLoginStatus(function(response) {
                    if (response.status === 'connected') {
                        FB.api('me/og.likes', 'post', {object: view.model.get('fb_id')}, function(response){
                            //console.log(response);
                        });
                    } else {
                        FB.login(function(response) {
                            if (response.authResponse) {
                                FB.api('me/og.likes', 'post', {object: view.model.get('fb_id')}, function(response){
                                    //console.log(response);
                                });
                            }
                        }, {scope: 'publish_actions'});
                    }
                });

            });
        },

        addProduct: function (e) {
            var view = this;
            //getting FB object
            require(['fb'], function (FB) {
                FB.getLoginStatus(function(response) {
                    if (response.status === 'connected') {
                        FB.api('me/mercher:add', 'post', {product: view.model.get('fb_id')}, function(response){
                            //console.log(response);
                        });
                    } else {
                        FB.login(function(response) {
                            if (response.authResponse) {
                                FB.api('me/mercher:add', 'post', {product: view.model.get('fb_id')}, function(response){
                                    //console.log(response);
                                });
                            }
                        }, {scope: 'publish_actions'});
                    }
                });

            });
        },

        goToProducts: function () {
            router.navigate('products', {trigger: true});
        }

    });

});