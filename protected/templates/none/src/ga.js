define(['google-analytics'], function () {
    if (typeof appConfig.GA != 'undefined' && typeof appConfig.GA.id != 'undefined') {
        ga('create', appConfig.GA.id, 'auto');
    }
    return ga;
});