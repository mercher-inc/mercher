define(function (require, exports, module) {

    "use strict";

    var Backbone = require('backbone'),
        UniqueModel = require('backbone.uniquemodel');

    return UniqueModel(
        Backbone.Model.extend({
            urlRoot: module.config().urlRoot
        })
    );

});