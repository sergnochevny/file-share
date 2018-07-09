<?php

namespace backend\assets;

use yii\web\AssetBundle;

/**
 * Main backend application asset bundle.
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';

    public $css = YII_ENV_DEV?[
        'css/theme/application.css',
        'css/theme/elephant.css',
        'css/theme/login.css',
        'css/theme/main.css',
        'css/theme/profile.css',
        'css/theme/vendor.css',
    ]:[
        'css/theme/application.min.css',
        'css/theme/elephant.min.css',
        'css/theme/login.min.css',
        'css/theme/main.min.css',
        'css/theme/profile.min.css',
        'css/theme/vendor.min.css',
    ];

    public $js = YII_ENV_DEV?[
        'js/theme/elephant.min.js',
        'js/theme/application.js',
        'js/theme/main.js',
    ]:[
        'js/theme/elephant.min.js',
        'js/theme/application.min.js',
        'js/theme/main.min.js',
        'js/beforeunload.min.js',
    ];

    public $depends = [
        'yii\web\YiiAsset',
        'sn\utilities\assets\ExtLibAsset'
    ];
}
