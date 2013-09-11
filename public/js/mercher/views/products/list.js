Mercher.Views.Products.List = Backbone.View.extend({
    tagName: "div",
    attributes: {class: 'products-list'},
    template: Mercher.Templates.Products.List,
    events          : {
        "click .create": "createModel"
    },
    initialize: function () {
        this.listenTo(this.collection, "reset", this.render);
        this.listenTo(this.collection, "sync", this.render);
    },
    render: function () {
        var self = this;
        this.$el.html(this.template({collection: self.collection}));
        this.collection.each(function (model) {
            var view = new Mercher.Views.Products.Item({model: model, collection: self.collection});
            var list = self.$el.find('.list:first');
            list.append(view.$el);
            view.render();
        });
        return this;
    },
    createModel     : function (event) {
        var model = new this.collection.model;
        model.urlRoot = this.collection.url;
        var shopsCreationView = new Mercher.Views.Products.Create({model: model, collection: this.collection});
        /*
        shopsCreationView.communitiesGroups = new CommunitiesGroups();
        shopsCreationView.communitiesGroups.fetch({success: function () {
            shopsCreationView.render();
        }});
        */
        shopsCreationView.render();

        return false;
    }
});