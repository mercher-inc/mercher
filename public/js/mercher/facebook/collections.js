Mercher.Facebook.Collections = {};

Mercher.Facebook.Collections.Base = Backbone.Collection.extend({
    initialize: function () {
        _.bindAll(this, 'parse');
    },
    model     : Mercher.Facebook.Models.Base,
    sync: function (method, collection, options) {
        FB.getLoginStatus(function(response) {
            FB.api(
                collection.url,
                function(response) {
                    console.log(response);
                }
            );
        });
        console.log(method);
        console.log(collection);
        console.log(options);
        console.log(collection.url);
    },
    parse     : function (response) {
        this.data = {};
        this.data.limit = response.limit;
        this.data.count = response.count;
        this.data.page = response.page;
        if (typeof response.url != 'undefined') {
            this.url = response.url;
        }
        return response.models;
    }
});