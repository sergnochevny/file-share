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
<div class="row">
    <div class="col-sm-12">
        <div class="row">
            <div class="col-sm-6">
                <div class="h3 no-outer-offset-top">
                    <i class="fa fa-contao"></i> <?= Html::encode($this->title) ?><br>
                    <small>List of all company accounts</small>
                </div>
            </div>
            <div class="col-sm-6 text-right"></div>
        </div>
        <?php Pjax::begin(['options' => ['class' => 'row']]); ?>
            <?= $this->render('partials/_search', ['model' => $searchModel]); ?>
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
</div>