<?php

Yii::app()->clientScript->registerPackage('mercher/facebook/collections/pages');
$obj = 'Mercher.asdasdasdasdasdfghfgh';
Yii::app()->clientScript->registerScript(
    'asdasdasdasdasdfghfgh',
    "$obj = {};\n" .
        "$obj.collection = new Mercher.Facebook.Collections.Pages();\n" .
        //"$obj.view = new Mercher.Views.Shops.List({collection: $obj.collection});\n" .
        //"$obj.view.\$el.appendTo(\"#asdasdasdasdasdfghfgh\");\n" .
        "$obj.collection.fetch();\n",
    ClientScript::POS_FB
);
?>