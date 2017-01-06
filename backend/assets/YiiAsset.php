<?php


namespace backend\assets;


class YiiAsset extends \yii\web\AssetBundle
{
    public $sourcePath = '@yii/assets';
    public $js = [
        'yii.js',
    ];
    public $depends = [
        'backend\assets\AppAsset',
    ];

}