<?php

use yii\helpers\Html;
use yii\grid\GridView;
use common\helpers\Url;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel backend\models\search\HistorySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'History';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="title-bar">
    <div class="title-bar-actions">
        <?= Html::a(Html::tag('span', Html::tag('span', '', ['class' => 'icon icon-chevron-circle-left icon-lg icon-fw']), ['class' => 'btn-label']) . ' Back', Url::previous('back'), ['class' => 'btn btn-labeled arrow-default']) ?>
    </div>
    <h1 class="title-bar-title">
        <span class="d-ib"><span class="icon icon-history"></span> <b><?= Html::encode($this->title) ?></b></span>
    </h1>
    <p class="title-bar-description">
        <small>List of all company accounts</small>
    </p>
</div>
<div class="row gutter-xs">
    <div class="col-xs-12">
        <div class="panel panel-default">
            <?php Pjax::begin(['id' => 'history_index', 'enablePushState' => false, 'timeout' => 0, 'options' => ['class' => 'panel-body panel-collapse']]); ?>
                <?= $this->render('/search/_search', ['model' => $searchModel]); ?>
                <?= GridView::widget([
                    'dataProvider' => $dataProvider,
                    'tableOptions' => ['class' => 'table table-hover table-striped  dataTable no-footer dtr-inline'],
                    'summaryOptions' => ['class' => 'col-sm-6'],
                    'pager' => [
                        'options' => [
                            'class' => 'col-sm-6',
                        ]
                    ],
                    'options' => ['class' => 'row'],
                    'layout'=>"<div class='col-sm-12'>{items}</div>\n{summary}{pager}",
                    'columns' => [
                        [
                            'attribute' => 'name',
                            'value' => function ($model, $key, $index, $column) {
                                $model->{$column->attribute};
                            }
                        ],
                        [
                            'attribute' => 'created_at',
                            'label' => 'Archived at',
                            'value' => function ($model, $key, $index, $column) {
                                $value = '<span class="label label-warning" >' .  Yii::$app->formatter->asDate($model->{$column->attribute}) . '</span >';
                                return $value;
                            }
                        ],
                        ['class' => 'yii\grid\ActionColumn'],
                    ],
                ]); ?>
            <?php Pjax::end(); ?>
        </div>
    </div>
</div>