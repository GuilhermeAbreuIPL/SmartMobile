<?php
return [
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
        '@uploads' => '@backend/web/uploads',
    ],
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'components' => [
        'authManager' => [
            'class' => 'yii\rbac\DbManager', // ou 'yii\rbac\PhpManager' se for o caso
        ],
        'cache' => [
            'class' => \yii\caching\FileCache::class,
        ],
    ],
];
