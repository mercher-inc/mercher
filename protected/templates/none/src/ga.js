define(['google-analytics'], function (ga) {
    if (typeof appConfig.GA != 'undefined' && typeof appConfig.GA.id != 'undefined') {
        ga('create', appConfig.GA.id, 'auto');
    }
    return ga;
});