Mercher.Templates.Shops.List = _.template(
    '<table class="table table-hover">' +
        '<thead>' +
            '<tr>' +
                '<td>Title</td>' +
                '<td>Description</td>' +
                '<td>' +
                    '<div class="btn-group pull-right">' +
                        '<button class="btn btn-primary">Create</button>' +
                    '</div>' +
                '</td>' +
            '</tr>' +
        '</thead>' +
        '<tbody class="list"></tbody>' +
    '</table>'
);