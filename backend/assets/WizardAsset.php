<?php
namespace backend\assets;

use yii\web\AssetBundle;

class WizardAsset extends AssetBundle
{
    public $sourcePath =  __DIR__ . '/js/';

    public $baseUrl = '@web';

    public $js = [
        'wizard.js',

    ];

    public $depends = [
        'yii\web\JqueryAsset',
    ];
}