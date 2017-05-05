<?php

namespace backend\assets;

use yii\web\AssetBundle;

/**
 * Main backend application asset bundle.
 */
class InputUploadSubmitAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';

    public $js = YII_ENV_DEV?[
        'js/input_upload_submit.js',
    ]:[
        'js/input_upload_submit.min.js',
    ];

    public $depends = [
        'yii\web\JqueryAsset',
    ];
}
