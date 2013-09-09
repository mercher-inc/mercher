Mercher.Views.Products.Item = Backbone.View.extend({
    tagName: "tr",
    attributes: {class: 'products-item'},
    template: Mercher.Templates.Products.Item,
    initialize: function () {
        this.listenTo(this.model, "change", this.render);
        this.listenTo(this.model, "remove", this.remove);
    },
    render: function () {
        this.$el.html(this.template({model: this.model}));
        return this;
    }
});