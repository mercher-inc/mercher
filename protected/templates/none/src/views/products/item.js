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

                FB.api(
                    'me/og.likes?object=' + view.model.get('fb_id'),
                    function (response) {
                        $(".likeBtn", view.$el).removeClass('hidden');
                        if (response && response.data && response.data.length) {
                            $(".likeBtn", view.$el).attr('data-action-id', response.data[0].id);
                            $(".likeBtn", view.$el).addClass('active');
                        }
                    }
                );

                FB.api(
                    'me/mercher:add?object=' + view.model.get('fb_id'),
                    function (response) {
                        $(".addBtn", view.$el).removeClass('hidden');
                        if (response && response.data && response.data.length) {
                            $(".addBtn", view.$el).attr('data-action-id', response.data[0].id);
                            $(".addBtn", view.$el).addClass('active');
                        }
                    }
                );
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

        goToProducts: function () {
            router.navigate('products', {trigger: true});
        },

        login: function(success) {
            //getting FB object
            require(['fb'], function (FB) {
                FB.getLoginStatus(function(response) {
                    if (response.status === 'connected') {
                        success();
                    } else {
                        FB.login(function(response) {
                            if (response.authResponse) {
                                success();
                            }
                        }, {scope: 'publish_actions'});
                    }
                });
            });
        },

        likeProduct: function (e) {
            var view = this;
            this.login(function(){
                if ($(".likeBtn", view.$el).hasClass('active')) {
                    view._unlikeProduct();
                } else {
                    view._likeProduct();
                }
            });
        },

        addProduct: function (e) {
            var view = this;
            this.login(function(){
                if ($(".addBtn", view.$el).hasClass('active')) {
                    view._removeProduct();
                } else {
                    view._addProduct();
                }
            });
        },

        _likeProduct: function() {
            var view = this;
            FB.api(
                'me/og.likes',
                'post',
                {
                    object: view.model.get('fb_id')
                },
                function(response){
                    if (typeof response.id != 'undefined') {
                        $(".likeBtn", view.$el).attr('data-action-id', response.id);
                        $(".likeBtn", view.$el).addClass('active');
                        require(['ga'], function (ga) {
                            ga(
                                'send',
                                'social',
                                'facebook',
                                'like',
                                'products/' + view.model.id
                            );
                        });
                    }
                }
            );
        },

        _unlikeProduct: function() {
            var view = this;
            FB.api(
                $(".likeBtn", view.$el).attr('data-action-id'),
                'delete',
                function () {
                    $(".likeBtn", view.$el).removeAttr('data-action-id');
                    $(".likeBtn", view.$el).removeClass('active');
                    require(['ga'], function (ga) {
                        ga(
                            'send',
                            'social',
                            'facebook',
                            'unlike',
                            'products/' + view.model.id
                        );
                    });
                }
            );
        },

        _addProduct: function() {
            var view = this;
            FB.api(
                'me/mercher:add',
                'post',
                {
                    product: view.model.get('fb_id')
                },
                function(response){
                    if (typeof response.id != 'undefined') {
                        $(".addBtn", view.$el).attr('data-action-id', response.id);
                        $(".addBtn", view.$el).addClass('active');
                        require(['ga'], function (ga) {
                            ga(
                                'send',
                                'social',
                                'facebook',
                                'add',
                                'products/' + view.model.id
                            );
                        });
                    }
                }
            );
        },

        _removeProduct: function () {
            var view = this;
            FB.api(
                $(".addBtn", view.$el).attr('data-action-id'),
                'delete',
                function () {
                    $(".addBtn", view.$el).removeAttr('data-action-id');
                    $(".addBtn", view.$el).removeClass('active');
                    require(['ga'], function (ga) {
                        ga(
                            'send',
                            'social',
                            'facebook',
                            'remove',
                            'products/' + view.model.id
                        );
                    });
                }
            );
        }

    });

});