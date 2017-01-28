<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel backend\models\InvestigationSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Investigations';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="col-sm-12">

    <div class="row">
        <div class="col-sm-6">
            <div class="h2 no-outer-offset-top"><?= Html::encode($this->title) ?></div>
        </div>
        <div class="col-sm-6 text-right"></div>
    </div>
    <?= $this->render('partials/_search', ['model' => $searchModel]); ?>
    <?php Pjax::begin(); ?>
        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
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
