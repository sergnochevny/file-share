<?php

namespace backend\assets;

use yii\web\AssetBundle;

/**
 * Main backend application asset bundle.
 */
class WizardUserAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';

    public $js = YII_ENV_DEV?[
        'js/wizard.user.js',
    ]:[
        'js/wizard.user.min.js',
    ];

    public $depends = [
        'yii\web\JqueryAsset',
    ];
}
