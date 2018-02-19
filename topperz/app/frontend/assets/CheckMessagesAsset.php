<?php

namespace frontend\assets;

use yii\web\AssetBundle;


class CheckMessagesAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
    ];
    public $js = [
        'js/check_messages.js',
    ];
    public $depends = [
        'frontend\assets\AppAsset',
//        'yii\web\YiiAsset',
//        'yii\bootstrap\BootstrapAsset',
    ];
}
