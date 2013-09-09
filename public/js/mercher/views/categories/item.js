Mercher.Views.Categories.Item = Backbone.View.extend({
    tagName: "tr",
    attributes: {class: 'categories-item'},
    template: Mercher.Templates.Categories.Item,
    initialize: function () {
        this.listenTo(this.model, "change", this.render);
        this.listenTo(this.model, "remove", this.remove);
    },
    render: function () {
        this.$el.html(this.template({model: this.model}));
        return this;
    }
});