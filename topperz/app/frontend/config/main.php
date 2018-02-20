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
                    'pattern'   => 'logout',
                    'route'     => 'auth/logout',
                    'suffix'    => ''
                ],
                [
                    'pattern'   => 'user/index',
                    'route'     => 'user/index',
                    'suffix'    => ''
                ],
                [
                    'pattern'   => 'user/add-address',
                    'route'     => 'user/add-address',
                    'suffix'    => ''
                ],
                [
                    'pattern'   => 'user/change-password',
                    'route'     => 'user/change-password',
                    'suffix'    => ''
                ],
                [
                    'pattern'   => 'user/change-settings',
                    'route'     => 'user/change-settings',
                    'suffix'    => ''
                ],
                [
                    'pattern'   => 'auth/sign-in',
                    'route'     => 'auth/sign-in',
                    'suffix'    => ''
                ],
                [
                    'pattern'   => 'auth/sign-up',
                    'route'     => 'auth/sign-up',
                    'suffix'    => ''
                ],
                [
                    'pattern'   => 'login',
                    'route'     => 'content/login',
                    'suffix'    => ''
                ],
                [
                    'pattern'   => 'discounts/<alias>',
                    'route'     => 'discount/view',
                    'suffix'    => ''
                ],
                [
                    'pattern'   => 'discounts',
                    'route'     => 'discount/index',
                    'suffix'    => ''
                ],
                [
                    'pattern'   => '<alias:about|contacts|payment|delivery|get-sale>',
                    'route'     => 'content/static',
                    'suffix'    => ''
                ],


                [
                    'pattern'   => '<alias>/page/<page>',
                    'route'     => 'catalog/category',
                    'suffix'    => ''
                ],
                [
                    'pattern'   => '<alias>/<type:classic|proprietary>/sort/<sort>',
                    'route'     => 'catalog/sort',
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
