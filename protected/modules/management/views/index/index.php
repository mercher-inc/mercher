<?php
/* @var $this DefaultController */

$this->menu        = array(
    array(
        'label' => Yii::t('label', 'users'),
        'url'   => array('users/index')
    ),
    array(
        'label' => Yii::t('label', 'shops'),
        'url'   => array('shops/index')
    ),
    array(
        'label' => Yii::t('label', 'products'),
        'url'   => array('products/index')
    ),
    array(
        'label' => Yii::t('label', 'categories'),
        'url'   => array('categories/index')
    ),
    array(
        'label' => Yii::t('label', 'subscriptions'),
        'url'   => array('subscriptions/index')
    ),
);
$this->headerTitle = Yii::t('label', 'management');

$stats = [];

$ends = false;
for ($offset = -1 * (int)date('w'); floor($offset / (-7)) < 10; $offset -= 7) {
    $starts = date('Y-m-d', strtotime($offset . ' days'));
    $week         = date('W', strtotime($starts));
    $stats[$week] = [
        'Users'      => 0,
        'Shops'      => 0,
        'Products'   => 0,
        'Categories' => 0
    ];

    if ($ends) {
        $conditions = [
            'condition' => 'created > :starts AND created < :ends',
            'params'    => [
                'starts' => $starts,
                'ends'   => $ends
            ]
        ];
    } else {
        $conditions = [
            'condition' => 'created > :starts',
            'params'    => [
                'starts' => $starts
            ]
        ];
    }

    $stats[$week]['Users']      = (int)User::model()->count($conditions);
    $stats[$week]['Shops']      = (int)Shop::model()->count($conditions);
    $stats[$week]['Products']   = (int)Product::model()->count($conditions);
    $stats[$week]['Categories'] = (int)Category::model()->count($conditions);

    $ends = $starts;
}

$grid = [['Week', 'Users', 'Shops', 'Products', 'Categories']];

foreach (array_reverse($stats, true) as $week=>$params) {
    $grid[] = [(string)$week, $params['Users'], $params['Shops'], $params['Products'], $params['Categories']];
}


Yii::app()->clientScript->registerScriptFile('https://www.google.com/jsapi');
Yii::app()->clientScript->registerScript(
    'application_chart',
    'google.load("visualization", "1", {packages:["corechart"]});
    google.setOnLoadCallback(drawChart);
    function drawChart() {
        var data = google.visualization.arrayToDataTable('.CJSON::encode($grid).');

        var options = {
          title: "Mercher usage",
          backgroundColor: "transparent"
        };

        var chart = new google.visualization.LineChart(document.getElementById("chart_div"));
        chart.draw(data, options);
      }
    ',
    ClientScript::POS_END
);

echo CHtml::tag('div', ['id' => 'chart_div', 'style' => 'width: 100%; height: 500px;'])

?>