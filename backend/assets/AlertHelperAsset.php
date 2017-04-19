<?php

namespace backend\assets;

use yii\web\AssetBundle;

/**
 * Main backend application asset bundle.
 */
class AlertHelperAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';

    public $js = YII_ENV_DEV?[
        'js/alert.helper.js',
    ]:[
        'js/alert.helper.min.js',
    ];

    public $depends = [
        'yii\web\JqueryAsset',
    ];
}
