<?php


namespace backend\controllers;


use yii\web\Controller;

class FileController extends Controller
{
    public function actionIndex()
    {
        return $this->render('all-files');
    }
}