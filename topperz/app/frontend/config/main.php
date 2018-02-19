<?php
$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);

return [
    'id'                    => 'app-frontend',
    'name'                  => 'Dashboard',
    'basePath'              => dirname(__DIR__),
    'bootstrap'             => ['log'],
    'controllerNamespace'   => 'frontend\controllers',
    'components' => [
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            'useFileTransport' => false,
        ],

        'request' => [
            'csrfParam'     => 'digital_force',
            'baseUrl'       => '/',
            'class'               => 'common\components\LangRequest', // for multiLang
            'cookieValidationKey' => 'NtC8TLEAnI8DYwWjrjdaauocn_HQfZ-p',
        ],
        'liqpay' => [
            'class' => 'common\components\LiqPay',
        ],
        'user'   => [
            'identityClass'     => 'common\models\User',
            'enableAutoLogin'   => false,
            'identityCookie'    => ['name' => '_identity-frontend', 'httpOnly' => false],
        ],
        'session' => [
            // this is the name of the session cookie used for login on the frontend
            'name' => 'advanced-frontend',
        ],
        'log' => [
            'traceLevel'    => YII_DEBUG ? 3 : 0,
            'targets'       => [
                [
                    'class'     => 'yii\log\FileTarget',
                    'levels'    => ['error', 'warning'],
                ],
            ],
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'urlManager' => [
            'class'               => 'common\components\LangUrlManager', // for multiLang
            'enablePrettyUrl'     => true,
            'showScriptName'      => false,
            'enableStrictParsing' => false,
            'rules' => [
              

                [
                    'pattern'   => '',
                    'route'     => 'content/index',
                    'suffix'    => ''
                ],


                [
                    'pattern'   => '<alias>/page/<page>',
                    'route'     => 'catalog/category',
                    'suffix'    => ''
                ],
                [
                    'pattern'   => '<alias>/sort/<sort>',
                    'route'     => 'catalog/sort',
                    'suffix'    => ''
                ],
                [
                    'pattern'   => '<alias>/<type:classic|proprietary>',
                    'route'     => 'catalog/type',
                    'suffix'    => ''
                ],
                [
                    'pattern'   => '<alias>',
                    'route'     => 'catalog/category',
                    'suffix'    => ''
                ],
                [
                    'pattern'   => '<alias>/<name_alt>',
                    'route'     => 'catalog/product',
                    'suffix'    => ''
                ],
                [
                    'pattern'   => '<_c>/<_a>',
                    'route'     => '<_c>/<_a>',
                    'suffix'    => '',
                ],

            ],
        ],
        'language'     => 'ru-RU',
        'i18n'         => [
            'translations' => [
                '*' => [
                    'class'    => 'yii\i18n\PhpMessageSource',
                    'basePath' => '@app/messages',
                ],
            ],
        ],
        // выключаем bootstap
        'assetManager' => [
            'bundles' => [
                'yii\bootstrap\BootstrapAsset' => [
                    'css'   => [],
                ],
                'yii\bootstrap\BootstrapPluginAsset' => [
                    'js'    =>[]
                ],
            ],
        ],
    ],
    'params' => $params,
];
