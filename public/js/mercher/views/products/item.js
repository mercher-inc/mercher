Mercher.Views.Products.Item = Backbone.View.extend({
    tagName: "tr",
    attributes: {class: 'products-item'},
    template: Mercher.Templates.Products.Item,
    events: {
        "click .update": "updateModel",
        "click .delete": "deleteModel",
        "click .like": "likeModel"
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
        var shopsDeletionView = new Mercher.Views.Products.Delete({model: this.model, collection: this.collection});
        shopsDeletionView.render();
        return false;
    },
    likeModel: function () {
        var view = this;
        $button = $('.like', view.$el);
        $button.button('loading');
        FB.api(
            'me/og.likes',
            'post',
            {
                object: view.model.id,
                privacy: {
                    value: 'SELF'
                }
            },
            function (response) {
                if (!response || response.error) {
                    $button.button('reset');
                } else {
                    $button.button('liked');
                }
            }
        );
        return false;
    }
});