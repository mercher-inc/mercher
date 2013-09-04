<?php


Yii::app()->clientScript->registerScript(
    'fb_get_profile',
    'FB.getLoginStatus(function(response) {' .
        'if (response.status == \'connected\') {' .
            'FB.api(\'/me/accounts\', function(response) {' .
                'console.log(response);' .
            '});'.
        '}'.
    '});',
    ClientScript::POS_FB
);

?>