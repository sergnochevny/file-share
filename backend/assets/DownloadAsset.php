<?php

namespace backend\assets;

use yii\web\AssetBundle;

/**
 * Main backend application asset bundle.
 */
class DownloadAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';

    public $js = YII_ENV_DEV?[
        'js/download.js',
    ]:[
        'js/download.min.js',
    ];

    public $depends = [
        'yii\web\JqueryAsset',
    ];
}
