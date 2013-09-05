<?php


Yii::app()->clientScript->registerScript(
    'fb_get_profile',
    'FB.Event.subscribe(\'auth.statusChange\', function(response) {' .
        'if (response.status == \'connected\') {' .
            'FB.api(\'/me/accounts\', function(response) {' .
                'console.log(response);' .
            '});'.
        '}'.
    '});',
    ClientScript::POS_FB
);

?>