Mercher.Models.Shops = Mercher.Models.Base.extend({
    urlRoot : '/api/shops',
    isNew: function() {
        return (typeof this.attributes.created == 'undefined' || !this.attributes.created);
    }
});