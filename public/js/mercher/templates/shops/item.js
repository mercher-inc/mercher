Mercher.Templates.Shops.Item = _.template(
        '<td>' +
            '<%- model.get(\'title\') %>' +
        '</td>' +
        '<td>' +
            '<%- model.get(\'description\') %>' +
        '</td>' +
        '<td>' +
            '<div class="btn-group pull-right" style="white-space: nowrap;">' +
                '<button class="btn btn-default">Edit</button>' +
                '<button class="btn btn-danger">Delete</button>' +
            '</div>' +
        '</td>'
);