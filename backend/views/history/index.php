<?php

use ait\utilities\helpers\Url;
use common\widgets\Alert;
use yii\grid\GridView;
use yii\helpers\Html;
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
        <?php if (\backend\models\User::isClient()): ?>
            <small>List of all applicants</small>
        <?php else: ?>
            <small>List of all companies, applicants, files</small>
        <?php endif ?>
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
                                        return '<span class=" success-text"><span class="icon icon-file"></span> ' . ucfirst($model->{$column->attribute}) .'</span>';
                                        break;
                                    case 'company';
                                        return '<span class="warning-text"><span class="icon icon-building"></span> ' . ucfirst($model->{$column->attribute}) .'</span>';
                                        break;
                                    case 'investigation';
                                        return '<span class="danger-text"><span class="icon icon-user-secret"></span> ' . ucfirst($model->{$column->attribute}) .'</span>';
                                        break;
                                }
                            },
                            'contentOptions' => [
                                'width' => 90
                            ]
                        ],
                        [
                            'attribute' => 'created_at',
                            'format' => 'html',
                            'label' => 'Archived on',
                            'value' => function ($model, $key, $index, $column) {
                                $formatter = Yii::$app->getFormatter();
                                $value = $model->{$column->attribute};
                                $dateTime = $formatter->asDatetime($value);
                                $date = $formatter->asDate($value);

                                return Html::tag('span', $date, [
                                    'class' => '',
                                    'title' => $dateTime,
                                ]);
                            },
                            'contentOptions' => [
                                'width' => 100
                            ]
                        ],
                        [
                            'class' => 'yii\grid\ActionColumn',
                            'template' => '{recover}',
                            'visible' => \Yii::$app->user->can('history.recover'),
                            'buttons' => [
                                'recover' => function ($url, $model) {
                                    $content = Html::a('Recover', Url::to(['/history/recover', 'id' => $model->id], true),
                                        [
                                            'class' => "btn btn-primary btn-xs",
                                            'title' => 'Recover',
                                            'aria-label' => "Recover",
                                            'data-method' => 'post',
                                            'data-pjax' => 1
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