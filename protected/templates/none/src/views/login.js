define(function (require) {

    "use strict";

    var $ = require('jquery'),
        _ = require('underscore'),
        Backbone = require('backbone'),
        Bootstrap = require('bootstrap'),
        tpl = require('text!app/tpl/login.html'),
        template = _.template(tpl);

    return Backbone.View.extend({

        initialize: function () {

        },

        events: {
            "click .login": "login",
            "click .browseProducts": "browseProducts"
        },

        render: function () {
            this.$el.html(template());
            return this;
        },

        login: function(event) {
            var $button = $(event.target);
            $button.button('loading');
            FB.login(function (response) {
                if (response.authResponse) {
                    FB.api('/me/permissions', function (response) {
                        if (response && response.data && response.data.length && _.has(response.data[0], 'publish_actions') ) {
                            FB.api('/me?fields=name,currency', function (response) {
                                if (response && response.id) {
                                    window.fbUser = response;
                                    window.router.navigate('products', {trigger: true});
                                } else {
                                    $button.button('reset');
                                }
                            });
                        } else {
                            $button.button('reset');
                        }
                    });
                } else {
                    $button.button('reset');
                }
            }, {scope: 'publish_actions'});
        },

        browseProducts: function(event) {
            window.router.navigate('products', {trigger: true});
        }

    });

});