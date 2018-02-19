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
                    'pattern'   => 'success',
                    'route'     => 'cart/success',
                    'suffix'    =>  '',
                ],
                [
                    'pattern'   => 'forms/callback',
                    'route'     => 'forms/callback',
                    'suffix'    =>  '',
                ],
                [
                    'pattern'   => 'user/save-question',
                    'route'     => 'user/save-question',
                    'suffix'    =>  '',
                ],
                [
                    'pattern'   => 'user/question',
                    'route'     => 'user/question',
                    'suffix'    =>  '',
                ],
                [
                    'pattern'   => 'user/index',
                    'route'     => 'user/index',
                    'suffix'    =>'',
                ],
                [
                    'pattern'   => 'user/orders',
                    'route'     => 'user/orders',
                    'suffix'    =>'',
                ],
                [
                    'pattern'   => 'forms/feedback',
                    'route'     => 'forms/feedback',
                    'suffix'    => ''
                ],
                [
                    'pattern'   => 'feedbacks/page/<page>',
                    'route'     => 'feedbacks/index',
                    'suffix'    => ''
                ],
                [
                    'pattern'   => 'feedbacks',
                    'route'     => 'feedbacks/index',
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
                    'pattern'   => '<alias:delivery|contacts|payment>',
                    'route'     => 'content/static',
                    'suffix'    => ''
                ],
                [
                    'pattern'   => '<alias:category>/page/<page>',
                    'route'     => 'catalog/category',
                    'suffix'    => ''
                ],
                [
                    'pattern'   => '<alias:category>',
                    'route'     => 'catalog/category',
                    'suffix'    => ''
                ],


                [
                    'pattern'   => 'logout',
                    'route'     => 'auth/logout',
                    'suffix'    => ''
                ],
                [
                    'pattern'   => 'auth/sign-up',
                    'route'     => 'auth/sign-up',
                    'suffix'    => ''
                ],
                [
                    'pattern'   => 'auth/sign-in',
                    'route'     => 'auth/sign-in',
                    'suffix'    => ''
                ],
                [
                    'pattern'   => 'user/delete-address',
                    'route'     => 'user/delete-address',
                    'suffix'    => ''
                ],
                [
                    'pattern'   => 'user/change-settings',
                    'route'     => 'user/change-settings',
                    'suffix'    => ''
                ],
                [
                    'pattern'   => 'user/change-password',
                    'route'     => 'user/change-password',
                    'suffix'    => ''
                ],
                [
                    'pattern'   => 'user/add-address',
                    'route'     => 'user/add-address',
                    'suffix'    => ''
                ],
                [
                    'pattern'   => 'user/delete-address',
                    'route'     => 'user/delete-address',
                    'suffix'    => ''
                ],
                [
                    'pattern'   => 'user/change-address',
                    'route'     => 'user/change-address',
                    'suffix'    => ''
                ],
                [
                    'pattern'   => 'cart/new-order',
                    'route'     => 'cart/new-order',
                    'suffix'    => '',
                ],
                [
                    'pattern'   => 'order',
                    'route'     => 'cart/order',
                    'suffix'    => '',
                ],


                [
                    'pattern'   => 'cart/clear',
                    'route'     => 'cart/clear',
                    'suffix'    => '',
                ],
                [
                    'pattern'   => 'cart/change-count',
                    'route'     => 'cart/change-count',
                    'suffix'    => ''
                ],
                [
                    'pattern'   => 'cart/delete-from-backet',
                    'route'     => 'cart/delete-from-backet',
                    'suffix'    => ''
                ],
                [
                    'pattern'   => 'cart/request',
                    'route'     => 'cart/request',
                    'suffix'    => ''
                ],
                [
                    'pattern'   => 'login',
                    'route'     => 'content/login',
                    'suffix'    => ''
                ],
                [
                    'pattern'   => 'auth/<key>',
                    'route'     => 'auth/registration',
                    'suffix'    => ''
                ],
                [
                    'pattern'   => 'logup',
                    'route'     => 'content/logup',
                    'suffix'    => ''
                ],
                [
                    'pattern'   => 'backet',
                    'route'     => 'cart/backet',
                    'suffix'    => ''
                ],
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
