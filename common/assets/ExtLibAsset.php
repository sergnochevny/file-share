<?php

namespace common\assets;

use yii\web\AssetBundle;


class ExtLibAsset extends AssetBundle
{
    public $sourcePath = '@bower/ext-lib';
    public $js = [
        'js/library.extends.js',
    ];
    public $css = [
        'css/waitloader.css',
        'css/confirm.css',
    ];
    public $depends = [
        'yii\web\JqueryAsset'
    ];
}