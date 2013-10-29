define(function (require) {

    "use strict";

    var $ = require('jquery'),
        _ = require('underscore'),
        Backbone = require('backbone'),
        Bootstrap = require('bootstrap'),
        tpl = require('text!app/tpl/products/list/item.html'),
        template = _.template(tpl);

    return Backbone.View.extend({

        className: 'col-sm-' + Math.round(12 / Math.sqrt(appConfig.perPageCount)),

        initialize: function () {
            this.listenTo(this.model, "sync", this.render);
        },

        events: {
            "click .likeProduct": "likeProduct",
            "click .description": "toggleDescription",
            "click .image": "openProduct",
            "click .title": "openProduct",
            "click .addToCart": "addToCart"
        },

        render: function () {
            this.$el.html(template({model: this.model}));
            this.checkLike();
            return this;
        },

        addToCart: function (event) {
            var obj = {
                "business": appConfig.shop.pp_merchant_id,
                "item_name": this.model.get('title'),
                "item_number": this.model.id,
                "currency_code": "USD"
            };

            if (this.model.get('amount')) {
                obj.amount = Math.ceil(this.model.get('amount') * 100) / 100;

                if (appConfig.shop.tax) {
                    obj.tax = Math.ceil(
                        this.model.get('amount') * (appConfig.shop.tax/100) * 100
                    ) / 100;
                }
            }

            PAYPAL.apps.MiniCart.addToCart(obj);
        },

        checkLike: function () {
            var view = this;
            var $button = $('.likeProduct', this.$el);
            $button.button('loading');
            FB.api(
                'me/og.likes?object=' + this.model.get('fb_id'),
                function (response) {
                    if (response && response.data && response.data.length) {
                        $button.attr('data-like-id', response.data[0].id);
                        $button.addClass('active');
                    } else {
                        $button.removeClass('active');
                    }
                    $button.button('reset');
                    view.getLikes();
                }
            );
        },

        likeProduct: function (event) {
            var view = this;
            var $button = $('.likeProduct', this.$el);
            $button.button('loading');

            checkStatus();

            function checkStatus() {
                FB.api('/me/permissions', function (response) {
                    if (response && response.data && response.data.length && _.has(response.data[0], 'publish_actions')) {
                        likeProduct();
                    } else {
                        logIn();
                    }
                });
            }

            function logIn() {
                FB.login(function (response) {
                    if (response.authResponse) {
                        FB.api('/me?fields=name,currency', function (response) {
                            if (response && response.id) {
                                window.fbUser = response;
                            }
                        });
                        FB.api('/me/permissions', function (response) {
                            if (response && response.data && response.data.length && _.has(response.data[0], 'publish_actions')) {
                                likeProduct();
                            } else {
                                $button.button('reset');
                                view.getLikes();
                            }
                        });
                    } else {
                        $button.button('reset');
                        view.getLikes();
                    }
                }, {scope: 'publish_actions'});
            }

            function likeProduct() {
                if ($button.hasClass('active')) {
                    FB.api(
                        $button.attr('data-like-id'),
                        'delete',
                        function () {
                            $button.button('reset');
                            $button.removeAttr('data-like-id');
                            $button.removeClass('active');
                            view.getLikes();
                        }
                    );
                } else {
                    FB.api(
                        'me/og.likes',
                        'post',
                        {
                            object: view.model.get('fb_id')
                        },
                        function (response) {
                            if (response && response.id) {
                                $button.button('reset');
                                $button.attr('data-like-id', response.id);
                                $button.addClass('active');
                                view.getLikes();
                            } else if (response.error && response.error.code == 3501) {
                                view.checkLike();
                            }
                        }
                    );
                }
            }

            return this;
        },

        getLikes: function () {
            var $button = $('.likeProduct, .dislikeProduct', this.$el);
            $button.button('loading');
            FB.api(
                this.model.get('fb_id') + '/likes?summary=1',
                function (response) {
                    $button.button('reset');
                    if (response && response.summary && response.summary.total_count) {
                        $button.html(response.summary.total_count);
                    } else {
                        $button.html(0);
                    }
                }
            );
        },

        toggleDescription: function () {
            $('.description', this.$el).toggleClass('closed');
        },

        openProduct: function () {
            window.router.navigate('products/' + this.model.id, {trigger: true});
        }

    });

});