Mercher.Templates.Shops.List = _.template(
    '<table class="table table-hover">' +
        '<thead>' +
            '<tr>' +
                '<th>Title</th>' +
                '<th>Description</th>' +
                '<th>' +
                    '<div class="btn-group pull-right">' +
                        '<button class="btn btn-primary">Create</button>' +
                    '</div>' +
                '</th>' +
            '</tr>' +
        '</thead>' +
        '<tbody class="list"></tbody>' +
    '</table>'
);