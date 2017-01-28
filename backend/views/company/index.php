<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel backend\models\CompanySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Companies';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="col-sm-12">

    <div class="row">
        <div class="col-sm-6">
            <div class="h2 no-outer-offset-top"><?= Html::encode($this->title) ?></div>
        </div>
        <div class="col-sm-6 text-right">
            <?= Html::a('Create Company', ['create'], ['class' => 'btn btn-success']) ?>
        </div>
    </div>
    <?= $this->render('partials/_search', ['model' => $searchModel]); ?>
    <?php Pjax::begin(['options' => ['class' => 'row']]); ?>
        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            //'filterModel' => $searchModel,
            'tableOptions' => ['class' => 'table table-hover table-striped  dataTable no-footer dtr-inline'],
            'options' => ['class' => 'col-sm-12'],
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],

                'id',
                'name',
                'address',
                'city',
                'state',
                // 'zip',
                // 'status',
                // 'created_at',
                // 'updated_at',
                ['class' => 'yii\grid\ActionColumn'],
            ],
        ]); ?>
    <?php Pjax::end(); ?>
</div>
