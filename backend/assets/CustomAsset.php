<?php


namespace backend\assets;


use yii\web\AssetBundle;

class CustomAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/main.css',

    ];
    public $js = [
        'js/main.js',

    ];
    public $depends = [
        'backend\assets\AppAsset',
    ];
}