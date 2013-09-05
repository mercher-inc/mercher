Mercher.Collections = {};

Mercher.Collections.Base = Backbone.Collection.extend({
    initialize: function () {
        _.bindAll(this, 'parse');
    },
    model     : Mercher.Models.Base,
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