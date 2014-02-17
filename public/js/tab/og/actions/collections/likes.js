define(function (require, exports, module) {

    "use strict";

    var Backbone = require('backbone'),
        LikeModel = require('og/actions/models/like');

    return Backbone.Collection.extend({
        url: module.config().url,
        model: LikeModel,

        initialize: function (models, options) {
            this.object = options.object;
        },

        sync: function (method, collection, options) {
            require(['fb'], function (FB) {
                var authResponse = FB.getAuthResponse();
                if (authResponse) {
                    if (method === 'read') {
                        FB.api(
                            collection.url,
                            {
                                object: collection.object
                            },
                            function (response) {
                                if (response.error) {
                                    options.error(response.error);
                                } else if (response.data) {
                                    options.success(response.data);
                                }
                            }
                        );
                    } else {
                        //console.log(method, 'collection sync method');
                    }
                } else {
                    options.error();
                }
            });
        }
    });

});