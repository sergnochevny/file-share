<?php

namespace backend\assets;

use yii\web\AssetBundle;

/**
 * Main backend application asset bundle.
 */
class FormSearchAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';

    public $js = YII_ENV_DEV?[
        'js/form_search.js',
    ]:[
        'js/form_search.min.js',
    ];

    public $depends = [
        'yii\web\JqueryAsset',
    ];
}
