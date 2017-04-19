<?php

namespace backend\assets;

use yii\web\AssetBundle;

/**
 * Main backend application asset bundle.
 */
class WizardAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';

    public $js = YII_ENV_DEV?[
        'js/wizard.js',
    ]:[
        'js/wizard.min.js',
    ];

    public $depends = [
        'yii\web\JqueryAsset',
    ];
}
