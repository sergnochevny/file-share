<?php
/**
 * Copyright (c) 2017. AIT
 */

namespace backend\assets;

use yii\web\AssetBundle;

/**
 * Main backend application asset bundle.
 */
class WizardAdminAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';

    public $js = YII_ENV_DEV?[
        'js/wizard.admin.js',
    ]:[
        'js/wizard.admin.min.js',
    ];

    public $depends = [
        'yii\web\JqueryAsset',
    ];
}
