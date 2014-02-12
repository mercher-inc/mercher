define(function (require) {

    "use strict";

    var Backbone = require('backbone'),
        AddModel = require('og/actions/models/add'),
        FB = require('fb');

    return Backbone.Collection.extend({
        url: 'me/' + FB._namespace + ':add',
        model: AddModel,

        initialize: function (models, options) {
            this.object = options.object;
        },

        sync: function (method, collection, options) {
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
        }
    });

});