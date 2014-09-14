define(function (require, exports, module) {

    "use strict";

    //requirements
    var $ = require('jquery'),
        Backbone = require('backbone');

    var TabApplication = Backbone.Router.extend({
        controllers: {},
        mainLayout: {},
        shopModel: {},
        mainNav: {},
        cartDialog: {},
        cartItemsCollection: {},

        initialize: function () {
            var app = this,
                ShopModel = require('models/shop'),
                ProductsController = require('controllers/products'),
                OrdersController = require('controllers/orders'),
                MainLayout = require('views/layouts/main'),
                MainNav = require('views/nav/main'),
                CartDialog = require('views/dialogs/cart'),
                CartItemsCollection = require('collections/cartItems');

            this.shopModel = new ShopModel(module.config().data.shop);

            this.controllers.products = new ProductsController({router: this});
            this.controllers.orders = new OrdersController({router: this});

            this.mainLayout = new MainLayout({el: 'body', router: this});
            this.mainLayout.render();

            this.cartItemsCollection = new CartItemsCollection();
            this.cartDialog = new CartDialog({router: this, collection: this.cartItemsCollection});

            require(['fb'], function (FB) {
                FB.Event.subscribe('auth.statusChange', function (response) {
                    if (response.status === 'connected') {
                        app.cartItemsCollection.fetch({data: {limit: -1}});
                    }
                });
            });

            this.mainNav = new MainNav({router: this});
            this.mainLayout.setView('header#header', this.mainNav);
            this.mainNav.render();

            this.mainLayout.insertView('#dialogs', this.cartDialog);
            this.cartDialog.render();
            this.cartDialog.$el.modal({
                backdrop: true,
                show: false
            });

            /*
            this.on('route', function (route, params) {
                console.log({route: '/' + route, params: params});
            });
            */

            Backbone.history.start({pushState: false});
            $(document).on('click', "a[href^='/']", function (e) {
                e.preventDefault();
                var href = $(e.currentTarget).attr('href');
                app.navigate(href, { trigger: true });
            });
        },

        checkPermissions: function (options) {
            var app = this;

            require(['fb'], function (FB) {
                FB.getLoginStatus(function (response) {
                    if (response.status === 'connected') {
                        FB.api(
                            '/me/permissions',
                            function (permissions) {
                                if (permissions.data && permissions.data.length) {
                                    var existingPermissions = _.keys(permissions.data[0]);
                                    var requiredPermissions = _.difference(options.scope, existingPermissions);
                                    if (requiredPermissions.length) {
                                        if (options.requestMissingPermissions) {
                                            app.login({
                                                scope: options.scope,
                                                success: function () {
                                                    app.checkPermissions({
                                                        scope: options.scope,
                                                        success: function () {
                                                            options.success();
                                                        },
                                                        error: function () {
                                                            options.error();
                                                        },
                                                        requestMissingPermissions: false
                                                    });
                                                },
                                                error: function () {
                                                    options.error();
                                                }
                                            });
                                        } else {
                                            options.error();
                                        }
                                    } else {
                                        options.success();
                                    }
                                } else {
                                    options.error();
                                }
                            }
                        );
                    } else {
                        options.error();
                    }
                });
            });

        },

        login: function (options) {
            require(['fb'], function (FB) {
                FB.login(function (response) {
                    if (response.authResponse) {
                        options.success();
                    } else {
                        options.error();
                    }
                }, {scope: options.scope.join(',')});
            });
        },

        authorize: function (options) {
            var app = this;

            require(['fb'], function (FB) {
                FB.getLoginStatus(function (response) {
                    if (response.status === 'connected') {
                        app.checkPermissions({
                            scope: options.scope,
                            success: function () {
                                options.success();
                            },
                            error: function () {
                                options.error();
                            },
                            requestMissingPermissions: true
                        });
                    } else {
                        app.login({
                            scope: options.scope,
                            success: function () {
                                app.checkPermissions({
                                    scope: options.scope,
                                    success: function () {
                                        options.success();
                                    },
                                    error: function () {
                                        options.error();
                                    },
                                    requestMissingPermissions: false
                                });
                            },
                            error: function () {
                                options.error();
                            }
                        });
                    }
                });
            });
        }
    });

    return new TabApplication();

});