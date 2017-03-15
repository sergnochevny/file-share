<?php

use backend\models\Investigation;
use common\widgets\Alert;
use yii\grid\GridView;
use yii\helpers\Html;
use common\helpers\Url;
use yii\widgets\Pjax;
use backend\models\User;

Pjax::begin(['id' => 'investigation_index', 'enablePushState' => false, 'timeout' => 0, 'options' => ['class' => 'panel-body panel-collapse']]);
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
            'attribute' => 'name',
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
                $value = '<span class="label label-warning" >' . Yii::$app->formatter->asDate($model->{$column->attribute}) . '</span >';
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
                $value = '<span class="label label-'. Investigation::getStatusCSSClass($code) .'" >' . Investigation::getStatusByCode($code) . '</span >';
                return $value;
            }
        ],
        [
            'class' => 'yii\grid\ActionColumn',
            'template' => '{edit}{delete}{view}',
            'contentOptions' => [
                'width' => 150,
            ],
            'buttons' => [
                'edit' => function ($url, $model) {
//@todo:TEST
//                    if (User::isAdmin()) {
//                        return '';
//                    }

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
//@todo:TEST
//                    if (User::isAdmin()) {
//                        return '';
//                    }

                    return Html::a('To archive', Url::to(['/investigation/archive', 'id' => $model->id], true),
                        [
                            'class' => "btn btn-danger btn-xs",
                            'title' => 'To archive',
                            'aria-label' => "To archive",
                            'data-confirm' => "Confirm removal",
                            'data-method' => "post",
                            'data-pjax' => "0",
                        ]
                    );
                },
                'view' => function ($url, $model) {
                    return Html::a('Details', Url::to(['/file', 'id' => $model->id], true),
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
