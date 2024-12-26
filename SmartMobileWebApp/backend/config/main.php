<?php
$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);

return [
    'id' => 'app-backend',
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'backend\controllers',
    'bootstrap' => ['log'],
    'modules' => [
        'api' =>[
            'class' => 'backend\modules\api\ModuleAPI',
        ]
    ],
    'components' => [
        'request' => [
            'csrfParam' => '_csrf-backend',
        ],
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => true,
            'identityCookie' => ['name' => '_identity-backend', 'httpOnly' => true],
        ],
        'session' => [
            // this is the name of the session cookie used for login on the backend
            'name' => 'advanced-backend',
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => \yii\log\FileTarget::class,
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
                //Rules relativas á auth
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => 'api/auth'
                ],
                //Rules relativas ao user
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => 'api/user',
                    'pluralize' => false,
                    'extraPatterns' => [
                        'GET' => 'show',
                        'PUT morada/{id}' => 'update-morada',
                        'PUT' => 'update-user-profile',
                    ]
                ],
                //Rules relativas ao produto
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => 'api/produto',
                    'pluralize'=>true,
                    'extraPatterns' => [
                        'GET' => 'produtos', /* api/produtos */
                        'GET {id}' => 'detalhe', /*api/produtos/{id}*/
                        'GET categoria/{id}' => 'categorias',
                    ],


                ],

            ],
        ],
    ],
    'params' => $params,
];
