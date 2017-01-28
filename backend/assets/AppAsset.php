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

    public $css = [
        'css/theme/application.min.css',
        'css/theme/elephant.min.css',
        'css/theme/login.min.css',
        'css/theme/main.min.css',
        'css/theme/profile.min.css',
        'css/theme/vendor.min.css',
    ];

    public $js = [
        'js/theme/vendor.min.js',
        'js/theme/elephant.min.js',
        'js/theme/application.min.js',
        'js/theme/main.min.js',
    ];

    public $depends = [
        'yii\web\YiiAsset',
        'common\assets\ExtLibAsset'
    ];
}
