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
        'css/main.css',
        'css/elephant.min.css',
    ];

    public $js = [
        'js/main.js',
    ];

    public $depends = [
        'yii\web\YiiAsset',
        'backend\assets\AdminLTEAsset',
        'common\assets\ExtLibAsset'
    ];
}
