Mercher.Templates.Pages.List = _.template(
    '<table class="table table-hover">' +
        '<thead>' +
            '<tr>' +
                '<td></td>' +
                '<td>Name</td>' +
                '<td>Description</td>' +
                '<td>Category</td>' +
                '<td>' +
                    '<div class="btn-group pull-right">' +
                        '<a href="//www.facebook.com/pages/create/" target="_blank" class="btn btn-primary">Create page</a>' +
                    '</div>' +
                '</td>' +
                '<td></td>' +
            '</tr>' +
        '</thead>' +
        '<tbody class="list"></tbody>' +
    '</table>'
);