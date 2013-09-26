define(function (require) {

    "use strict";

    var $           = require('jquery'),
        Backbone    = require('backbone'),
        DefaultLayout   = require('app/layouts/default'),

        $body = $('body'),
        defaultLayout = new DefaultLayout({el: $body}).render(),
        $content = $("#content", defaultLayout.el);

    return Backbone.Router.extend({

        routes: {
            "": "home",
            "contact": "contact",
            "employees/:id": "employeeDetails"
        },

        home: function () {
            console.log('home');
        }

    });

});