define(function (require, exports, module) {

    "use strict";

    var Backbone = require('backbone');

    return Backbone.Model.extend({
        urlRoot: module.config().urlRoot
    });

});