<?php

Yii::app()->clientScript->registerPackage('mercher/views/pages/list');
$obj = 'Mercher.asdasdasdasdasdfghfgh';
Yii::app()->clientScript->registerScript(
    'asdasdasdasdasdfghfgh',
    "$obj = {};\n" .
        "$obj.collection = new Mercher.Facebook.Collections.Pages();\n" .
        "$obj.view = new Mercher.Views.Pages.List({collection: $obj.collection});\n" .
        "$obj.view.\$el.appendTo(\"#asdasdasdasdasdfghfgh\");\n" .
        "$obj.collection.fetch({fields: 'id,username,category,name,description,has_added_app,access_token'});\n",
    ClientScript::POS_FB
);
?>

<div id="asdasdasdasdasdfghfgh"></div>