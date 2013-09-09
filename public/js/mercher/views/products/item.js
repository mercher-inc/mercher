Mercher.Views.Products.Item = Backbone.View.extend({
    tagName: "tr",
    attributes: {class: 'products-item'},
    template: Mercher.Templates.Products.Item,
    events: {
        "click .update": "updateModel",
        "click .delete": "deleteModel"
    },
    initialize: function () {
        this.listenTo(this.model, "change", this.render);
        this.listenTo(this.model, "remove", this.remove);
    },
    render: function () {
        this.$el.html(this.template({model: this.model}));
        return this;
    },
    updateModel: function () {
        var shopsEditingView = new Mercher.Views.Products.Update({model: this.model, collection: this.collection});
        /*
         shopsEditingView.communitiesGroups = new CommunitiesGroups();
         shopsEditingView.communitiesGroups.fetch({success: function () {
         shopsEditingView.render();
         }});
         */
        shopsEditingView.render();

        return false;
    },
    deleteModel: function () {
        var shopsDeletionView = new ManageCommunitiesDlgDeleteView({model: this.model, collection: this.collection});
        shopsDeletionView.render();
        return false;
    }
});