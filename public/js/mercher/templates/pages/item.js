Mercher.Templates.Pages.Item = _.template(
        '<td>' +
            '<img src="//graph.facebook.com/<%- model.get(\'id\') %>/picture" class="img-circle" style="height: 50px; width: 50px;" />' +
        '</td>' +
        '<td>' +
            '<%- model.get(\'name\') %>' +
        '</td>' +
        '<td>' +
            '<%- model.get(\'description\') %>' +
        '</td>' +
        '<td>' +
            '<%- model.get(\'category\') %>' +
        '</td>' +
        '<td>' +
            '<div class="btn-group pull-right" style="white-space: nowrap;">' +
                '<a href="//www.facebook.com/pages/edit_page/?id=<%- model.get(\'id\') %>" target="_blank" class="btn btn-default">Edit page</a>' +
            '</div>' +
        '</td>' +
        '<td>' +
            '<div class="btn-group pull-right" style="white-space: nowrap;">' +
                '<% if (model.get(\'has_added_app\')) { %>' +
                    '<% if (model.get(\'username\')) { %>' +
                        '<a class="btn btn-default" href="//www.facebook.com/<%- model.get(\'username\') %>/app_<%- fb_app_id %>" target="_blank">View tab</a>' +
                    '<% } %>' +
                '<% } else { %>' +
                    '<button class="btn btn-success add_shop">Add tab</button>' +
                '<% } %>' +
                '<a class="btn btn-default" href="/tabs/<%- model.get(\'id\') %>.html">Edit tab</a>' +
            '</div>' +
        '</td>'
);