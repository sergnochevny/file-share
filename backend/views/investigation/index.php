<?php

/* @var $this yii\web\View */
/* @var $searchModel backend\models\InvestigationSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;
use yii\widgets\Pjax;

$this->title = 'Applications';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="row">
    <div class="col-xs-12">
        <div class="row">
            <div class="col-sm-10">
                <div class="title-bar-title h3 no-outer-offset-top">
                    <span class="icon icon-save"></span> <?= Html::encode($this->title) ?><br>
                    <small>List of all applicants</small>
                </div>
            </div>
            <div class="col-sm-2 text-right">
                <?= Html::a('<span class="btn-label"><span class="icon icon-chevron-circle-left icon-lg icon-fw"></span></span> Back', Url::previous(), ['class' => 'btn btn-labeled arrow-default']) ?>
            </div>
        </div>

        <?php Pjax::begin(['options' => ['class' => 'row']]); ?>
            <?= $this->render('partials/_search', ['model' => $searchModel]); ?>
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
//                'filterModel' => $searchModel,
                'tableOptions' => ['class' => 'table table-hover table-striped  dataTable no-footer dtr-inline'],
                'options' => ['class' => 'col-sm-12'],
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],

                    'id',
                    'company_id',
                    'start_date',
                    'end_date',
                    'description',
                    // 'status',
                    // 'created_at',
                    // 'updated_at',

                    ['class' => 'yii\grid\ActionColumn'],
                ],
            ]); ?>
        <?php Pjax::end(); ?>
    </div>
</div>