<?php
return [
    'id' => 'app-backend-tests',
    'basePath' => dirname(__DIR__),
    'components' => [
        'assetManager' => [
            'basePath' => __DIR__ . '/../web/assets',
            'baseUrl' => '/assets',
        ],
        'urlManager' => [
            'showScriptName' => true,
            'enablePrettyUrl' => true,
            'rules' => [

            ],
        ],
        'request' => [
            'cookieValidationKey' => 'test',
        ],
        'db' => [
            'dsn' => 'mysql:host=127.0.0.1;dbname=smartmobile_test',
            'username' => 'root',
            'password' => '',
            'charset' => 'utf8',
        ],
    ],
    'params' => [
    ],
];

