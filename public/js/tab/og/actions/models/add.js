define(function (require) {

    "use strict";

    var Backbone = require('backbone'),
        FB = require('fb');

    return Backbone.Model.extend({

        sync: function (method, model, options) {
            var authResponse = FB.getAuthResponse();
            if (authResponse) {
                if (method === 'create') {
                    FB.api(
                        model.collection.url,
                        'post',
                        {
                            product: model.collection.object
                        },
                        function(response){
                            if (response.error) {
                                options.error(response.error);
                            } else {
                                options.success(response);
                            }
                        }
                    );
                } else if (method === 'delete') {
                    FB.api(
                        model.id,
                        'delete',
                        function(response){
                            if (response.error) {
                                options.error(response.error);
                            } else {
                                options.success(response);
                            }
                        }
                    );
                } else {
                    //console.log(method, 'model sync method');
                }
            } else {
                options.error();
            }
        }

    });

});