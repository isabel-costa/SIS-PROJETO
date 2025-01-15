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
        'api' => [
            'class' => 'backend\modules\api\ModuleAPI',
        ],
    ],
    'components' => [
        'request' => [
            'csrfParam' => '_csrf-backend',
            'enableCsrfValidation' => false,
            'parsers' => [
                'application/json' => 'yii\web\JsonParser', ]
        ],
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => true,
            'enableSession' => false,
            'loginUrl' => null,
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
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => 'api/bilhete',
                    'pluralize' => true,
                ],
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => 'api/carrinho',
                    'pluralize' => true,
                ],
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => 'api/favorito',
                    'pluralize' => true,
                    'extraPatterns' => [
                        'GET {profile_id}' => 'profilefav', //actionGetProfile
                    ],
                    'tokens' => [
                        '{profile_id}' => '<profile_id:\\d+>',
                    ],
                    
                ],
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => 'api/categoria',
                    'pluralize' => true,
                ],
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => 'api/evento',
                    'pluralize' => true,
                ],
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => 'api/fatura',
                    'pluralize' => true,
                ],
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => 'api/profile',
                ],
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => 'api/linhacarrinho',
                    'pluralize' => true,
                ],
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => 'api/linhafatura',
                    'pluralize' => true,
                ],
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => 'api/local',
                    'pluralize' => true,
                ],
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => 'api/zona',
                    'pluralize' => true,
                ],
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => 'api/user',
                    'pluralize' => true,
                ],
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => 'api/auth/login',
                    'extraPatterns' => [
                    'POST /api/auth/login' => 'api/auth/login',  // Endpoint de login
                    'POST /api/auth/protected-data' => 'api/auth/protected-data',  // Endpoint protegido
                    ]
                ],
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => 'api/auth/signup',
                    'pluralize' => false,
                ],
            ],
        ],
    ],
    'params' => $params,
];
