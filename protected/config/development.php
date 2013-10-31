<?php

$config = array_replace_recursive(
    require(dirname(__FILE__) . '/main.php'),
    [
        'components' => [
            'facebook' => [
                'appId'     => '631238416902634',
                'secret'    => '4dfa1e0fef9fc2bf785d2a8d36e415a3',
                'namespace' => 'mercherdev',
            ]
        ]
    ]
);

return $config;