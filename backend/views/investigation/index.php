<?php

/* @var $this yii\web\View */
/* @var $searchModel backend\models\InvestigationSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;
use yii\widgets\Pjax;

$this->title = 'Applicants';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="title-bar">
    <div class="title-bar-actions">
        <?= Html::a(Html::tag('span', Html::tag('span', '', ['class' => 'icon icon-chevron-circle-left icon-lg icon-fw']), ['class' => 'btn-label']) . ' Back', Url::previous('back'), ['class' => 'btn btn-labeled arrow-default']) ?>
    </div>
    <h1 class="title-bar-title">
        <span class="d-ib"><span class="icon icon-folder-open-o"></span> <?= Html::encode($this->title) ?></span>
    </h1>
    <p class="title-bar-description">
        <small>List of all applicants</small>
    </p>
</div>
<div class="row gutter-xs">
    <div class="col-xs-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <?= Html::a(Html::tag('span', Html::tag('span', '', ['class' => 'icon icon-plus icon-lg icon-fw']), ['class' => 'btn-label']) . ' Create a new applicant', Url::to(['/wizard/investigation']), ['class' => 'btn btn-sm btn-labeled arrow-success']) ?>
            </div>
            <?php Pjax::begin(['id' => 'investigation_index', 'enablePushState' => false, 'timeout' => 0, 'options' => ['class' => 'panel-body panel-collapse']]); ?>
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
                'layout' => "<div class='col-sm-12'>{items}</div>\n{summary}{pager}",
                'columns' => [
                    [
                        'attribute' => 'company_name',
                        'value' => 'company.name',
                        'label' => 'Company'
                    ],
                    'name',
                    [
                        'attribute' => 'start_date',
                        'label' => 'Start date',
                        'contentOptions' => [
                            'width' => 80,
                        ],
                        'format' => 'html',
                        'value' => function ($model, $key, $index, $column) {
                            $value = '<span class="label label-warning" >' . date('m.d.Y', $model->{$column->attribute}) . '</span >';
                            return $value;
                        }
                    ],
                    [
                        'attribute' => 'end_date',
                        'label' => 'Start date',
                        'format' => 'html',
                        'contentOptions' => [
                            'width' => 80,
                        ],
                        'value' => function ($model, $key, $index, $column) {
                            $value = '<span class="label label-warning" >' . date('m.d.Y', $model->{$column->attribute}) . '</span >';
                            return $value;
                        }
                    ],
                    'status',
                    [
                        'class' => 'yii\grid\ActionColumn',
                        'template' => '{edit}{delete}{details}',
                        'contentOptions' => [
                            'width' => 150,
                        ],
                        'buttons' => [
                            'edit' => function ($url, $model) {
                                return Html::a('Edit', Url::to(['/wizard/investigation', 'id' => $model->id], true),
                                    [
                                        'class' => "btn btn-primary btn-xs",
                                        'title' => 'Edit',
                                        'aria-label' => "Edit",
                                        'data-pjax' => "0",
                                    ]
                                );
                            },
                            'delete' => function ($url, $model) {
                                return Html::a('Delete', $url,
                                    [
                                        'class' => "btn btn-danger btn-xs",
                                        'title' => 'Delete',
                                        'aria-label' => "Delete",
                                        'data-confirm' => "Are you sure you want to delete this item?",
                                        'data-method' => "post",
                                        'data-pjax' => "0",
                                    ]
                                );
                            },
                            'details' => function ($url, $model) {
                                return Html::a('Details', $url,
                                    [
                                        'class' => "btn btn-success btn-xs",
                                        'title' => 'Details',
                                        'aria-label' => "Details",
                                        'data-pjax' => "0",
                                    ]
                                );
                            },
                        ],
                    ],
                ],
            ]); ?>
            <?php Pjax::end(); ?>
        </div>
    </div>
</div>