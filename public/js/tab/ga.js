define(function (require, exports, module) {

    ga('create', module.config().mainTrackerId, 'auto');
    if (module.config().shopTrackerId) {
        ga('create', module.config().shopTrackerId, 'auto', {name: 'shopTracker'});
    }
    return ga;

});