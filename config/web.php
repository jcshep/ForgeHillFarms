<?php

$params = require(__DIR__ . '/params.php');


$config = [
    'id' => 'forgehillfarms',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'defaultRoute' => 'site/home',
    'layout' => 'frontend',
    'components' => [
        'captcha' => [
            'name'    => 'captcha',
            'class' => 'szaboolcs\recaptcha\InvisibleRecaptcha',
            'siteKey' => '6LcwP-IZAAAAAOp_qp6Fx3WcRJ3Jy3f5ipCkhxk8',
            'secret' => '6LcwP-IZAAAAANcuUwrSBBtG-av-9R1ZQH1pHO_l',
        ],
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => 'D0Eei-d-Q5zBpQRQjMwBLULhgO9kQrfG',
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'user' => [
            'identityClass' => 'app\models\User',
            'enableAutoLogin' => true,
            'loginUrl' => [ 'user/login' ],
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'mailer' => require(__DIR__ . '/mailer.php'),
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'db' => require(__DIR__ . '/db.php'),
        'urlManager' => [
            'class' => 'yii\web\UrlManager',
            'showScriptName' => false,
            'enablePrettyUrl' => true,
            'rules' => require(__DIR__ . '/routes.php'),
        ],
        'formatter' => [
            // 'class' => 'yii\i18n\formatter',
            'thousandSeparator' => ',',
            'decimalSeparator' => '.',
            'currencyCode' => '$'
        ],
    ],
    'params' => $params,
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    // $config['bootstrap'][] = 'debug';
    // $config['modules']['debug'] = [
    //     'class' => 'yii\debug\Module',
    // ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
    ];
}

return $config;
