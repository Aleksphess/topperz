<?php

namespace frontend\assets;

use yii\web\AssetBundle;


class CheckGivenContactsAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
    ];
    public $js = [
        'js/check_contacts.js',
    ];
    public $depends = [
        'frontend\assets\CheckMessagesAsset',
    ];
}