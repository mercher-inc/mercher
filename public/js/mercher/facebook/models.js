Mercher.Facebook.Models = {};

Mercher.Facebook.Models.Base = Backbone.Model.extend({
    url: function () {
        baseUrl = '';
        if (typeof this.collection != 'undefined') {
            if (typeof this.collection.url == 'function') {
                baseUrl = this.collection.url();
            } else {
                baseUrl = this.collection.url;
            }
        } else {
            if (typeof this.urlRoot == 'function') {
                baseUrl = this.urlRoot();
            } else {
                baseUrl = this.urlRoot;
            }
        }
        baseUrlData = baseUrl.split("?");
        if (!this.isNew()) baseUrlData[0] += '/' + this.id;
        return baseUrlData.join('?');
    }
});