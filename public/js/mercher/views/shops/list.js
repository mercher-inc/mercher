Mercher.Views.Shops.List = Backbone.View.extend({
    tagName: "div",
    attributes: {class: 'shops-list'},
    template: Mercher.Templates.Shops.List,
    initialize: function () {
        this.listenTo(this.collection, "reset", this.render);
        this.listenTo(this.collection, "sync", this.render);
    },
    render: function () {
        var self = this;
        this.$el.html(this.template({collection: self.collection}));
        this.collection.each(function (model) {
            var view = new Mercher.Views.Shops.Item({model: model, collection: self.collection});
            var list = self.$el.find('.list:first');
            list.append(view.$el);
            view.render();
        });
        return this;
    }
});