<?php

use common\widgets\Alert;
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
                <div class="alert-container">
                    <?= Alert::widget() ?>
                </div>
                <?= $this->render('/search/_search', ['model' => $searchModel]); ?>
                <?= GridView::widget([
                    'dataProvider' => $dataProvider,
                    'tableOptions' => ['class' => 'table table-hover table-striped  dataTable no-footer dtr-inline'],
                    'summaryOptions' => ['class' => 'col-sm-6'],
                    'options' => ['class' => 'row'],
                    'layout'=>"<div class='col-sm-12'>{items}</div>\n{summary}{pager}",
                    'columns' => [
                        'name',
                        [
                            'attribute' => 'type',
                            'format' => 'html',
                            'label' => '',
                            'value' => function ($model, $key, $index, $column) {
                                switch ($model->{$column->attribute}){
                                    case 'file';
                                        return '<span class="label label-success">' . ucfirst($model->{$column->attribute}) .'</span>';
                                        break;
                                    case 'company';
                                        return '<span class="label label-warning">' . ucfirst($model->{$column->attribute}) .'</span>';
                                        break;
                                    case 'investigation';
                                        return '<span class="label label-error">' . ucfirst($model->{$column->attribute}) .'</span>';
                                        break;
                                }
                            },
                            'contentOptions' => [
                                'width' => 80
                            ]
                        ],
                        [
                            'attribute' => 'created_at',
                            'format' => 'html',
                            'label' => 'Archived at',
                            'value' => function ($model, $key, $index, $column) {
                                $value = '<span class="label label-warning" >' .  Yii::$app->formatter->asDate($model->{$column->attribute}) . '</span>';
                                return $value;
                            },
                            'contentOptions' => [
                                'width' => 80
                            ]
                        ],
                        [
                            'class' => 'yii\grid\ActionColumn',
                            'template' => '{details}',
                            'buttons' => [
                                'details' => function ($url, $model) {
                                    $content = Html::a('Details', Url::to(['/history/view', 'id' => $model->id], true),
                                        [
                                            'class' => "btn btn-success btn-xs",
                                            'title' => 'Details',
                                            'aria-label' => "Details",
                                        ]
                                    );
                                    return $content;
                                },
                            ],
                            'contentOptions' => [
                                'width' => 80
                            ]
                        ],
                    ],
                    'pager' => [
                        'options' => [
                            'class' => 'pagination pull-right',
                            'style' => 'margin-right:15px'
                        ]
                    ],
                ]); ?>
            <?php Pjax::end(); ?>
        </div>
    </div>
</div>