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
<div class="investigation-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?= $this->render('partials/_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Investigation', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
<?php Pjax::begin(); ?>    <?= GridView::widget([
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
<?php Pjax::end(); ?></div>
