<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\UserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Users';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="col-sm-12">

    <div class="row">
        <div class="col-sm-6">
            <div class="h2 no-outer-offset-top"><?= Html::encode($this->title) ?></div>
        </div>
        <div class="col-sm-6 text-right"></div>
    </div>
    <?php Pjax::begin(['options' => ['class' => 'row']]); ?>
        <?= $this->render('partials/_search', ['model' => $searchModel]); ?>
        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'options' => ['class' => 'col-sm-12'],
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],

                'first_name',
                'last_name',
                'phone_number',
                'email:email',
                'username',
                'created_at:date',
                'updated_at:date',

                ['class' => 'yii\grid\ActionColumn'],
            ],
        ]); ?>
    <?php Pjax::end(); ?>
</div>