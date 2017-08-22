<?php

use ait\utilities\helpers\Url;
use backend\models\Investigation;
use common\widgets\Alert;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\widgets\Pjax;

Pjax::begin([
    'id' => 'investigation_index',
    'enablePushState' => false,
    'timeout' => 0,
    'options' => ['class' => 'panel-body panel-collapse']
]);
?>
<div class="alert-container">
    <?= Alert::widget() ?>
</div>
<?= $this->render('/search/_search', ['model' => $searchModel]); ?>
<?= GridView::widget([
    'dataProvider' => $dataProvider,
    'tableOptions' => ['class' => 'table table-hover table-striped  dataTable no-footer dtr-inline'],
    'summaryOptions' => ['class' => 'col-sm-6'],
    'options' => ['class' => 'row'],
    'layout' => "<div class='col-sm-12'>{items}</div>\n{summary}{pager}",
    'columns' => [
        [
            'attribute' => 'company_name',
            'value' => 'company.name',
            'label' => 'Company'
        ],
        [
            'attribute' => 'fullName',
            'label' => 'Applicant',
            'headerOptions' => [
                'class' => 'hidden-sm hidden-xs',
            ],
            'contentOptions' => [
                'class' => 'hidden-sm hidden-xs',
            ],
        ],

        [
            'attribute' => 'start_date',
            'label' => 'Start date',
            'headerOptions' => [
                'class' => 'hidden-sm hidden-xs',
            ],
            'contentOptions' => [
                'class' => 'hidden-sm hidden-xs',
                'width' => 80,
            ],
            'format' => 'html',
            'value' => function ($model, $key, $index, $column) {
                $value = '<span class="" >' . Yii::$app->formatter->asDate($model->{$column->attribute}) . '</span >';
                return $value;
            }
        ],
        [
            'attribute' => 'status',
            'contentOptions' => [
                'width' => 80,
            ],
            'format' => 'html',
            'value' => function ($model, $key, $index, $column) {
                $code = $model->{$column->attribute};
                $value = '<span class=" ' . Investigation::getStatusCSSClass($code) . '-text" >' . Investigation::getStatusByCode($code) . '</span >';
                return $value;
            }
        ],
        [
            'class' => 'yii\grid\ActionColumn',
            'template' => '{edit}{delete}{view}',
            'contentOptions' => [
                'width' => 150,
            ],
            'visibleButtons' => [
                'edit' => \Yii::$app->user->can('wizard.investigation'),
                'delete' => \Yii::$app->user->can('investigation.archive'),
                'view' => \Yii::$app->user->can('file.index'),
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
                    return Html::a('Archive', Url::to(['/investigation/archive', 'id' => $model->id], true),
                        [
                            'class' => "btn btn-purple btn-xs",
                            'title' => 'Archive',
                            'aria-label' => "Archive",
                            'data-confirm' => "Confirm removal",
                            'data-method' => "post",
                        ]
                    );
                },
                'view' => function ($url, $model) {
                    return Html::a('Details', Url::to(['/file/index', 'id' => $model->id], true),
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
    'pager' => [
        'options' => [
            'class' => 'pagination pull-right',
            'style' => 'margin-right:15px'
        ]
    ],
]); ?>
<?php Pjax::end(); ?>
