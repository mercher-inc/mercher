Mercher.Facebook.Collections = {};

Mercher.Facebook.Collections.Base = Backbone.Collection.extend({
    initialize: function () {
        _.bindAll(this, 'parse');
        _.defaults(this, {data: {limit: 10, offset:0}});
    },
    model: Mercher.Facebook.Models.Base,
    sync: function (method, collection, options) {
        collection.data = _.defaults(_.omit(options, 'parse', 'success', 'error'), collection.data);
        switch (method) {
            case 'read':
                FB.getLoginStatus(function (response) {
                    FB.api(
                        collection.url,
                        collection.data,
                        function (response) {
                            if (typeof response.error != 'undefined') {
                                options.error(response);
                            } else {
                                options.success(response);
                            }
                        }
                    );
                });
                break;
            default:
                console.log(method);
                break;
        }
        /*
        console.log(collection);
        console.log(collection.data);
        */
    },
    parse: function (response) {
        //console.log(response);
        return response.data;
    }
});