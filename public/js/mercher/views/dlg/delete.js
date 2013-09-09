Mercher.Views.Dlg.Delete = Backbone.View.extend({
    tagName: "div",
    attributes: {tabindex: -1, role: 'dialog', "aria-hidden": 'true'},
    className: "modal fade",
    template: _.template(''),
    initialize: function () {
        this.$el.appendTo('body');
    },
    render: function () {
        this.$el.html(this.template({model: this.model}));
        this.$el.modal();
        return this;
    },
    events: {
        "click .close": "closeDlg",
        "click .cancel": "closeDlg",
        "click .delete": "deleteModel",
        "submit form": "deleteModel"
    },
    closeDlg: function () {
        view = this;
        view.$el.modal('hide');
        view.$el.on('hidden', function () {
            view.remove();
        });
        return false;
    },
    deleteModel: function (event) {
        var view = this;
        $dialog = view.$el;
        $button = $('.delete', $dialog);
        $button.button('loading');
        view.model.destroy({
            wait: true,
            success: function (model, response, options) {
                view.collection.fetch({data: view.collection.data});
                $button.button('reset');
                $dialog.modal('hide');
                $dialog.on('hidden', function () {
                    view.remove();
                });
            },
            error: function (model, xhr, options) {
                $button.button('reset');
            }
        });
        return false;
    }
});