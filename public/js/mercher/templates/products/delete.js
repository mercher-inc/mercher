Mercher.Templates.Products.Delete = _.template(
    '<div class="modal-dialog">' +
        '<div class="modal-content">' +
            '<div class="modal-header">'+
                '<button type="button" class="close">&times;</button>'+
                '<h3>Delete product "' +
                    '<% if (model.get(\'brand\')) { %>' +
                        '<%- model.get(\'brand\') %> ' +
                    '<% } %>' +
                    '<%- model.get(\'title\') %>' +
                '"</h3>'+
            '</div>'+
            '<div class="modal-body">'+
                '<p>Are you sure?</p>'+
                '</div>'+
            '<div class="modal-footer">'+
                '<button class="btn btn-default cancel">Close</button>'+
                '<button class="btn btn-primary delete">Delete</button>'+
            '</div>' +
        '</div>' +
    '</div>'
);