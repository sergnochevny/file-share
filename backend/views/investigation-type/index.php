<?php

use common\widgets\Alert;
use yii\helpers\Html;
use yii\grid\GridView;
use common\helpers\Url;
use yii\widgets\Pjax;
use yii\grid\SerialColumn;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\CompanySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Applicants types';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="title-bar">
    <div class="title-bar-actions">
        <a class="btn btn-labeled arrow-default" href="<?= Url::previous() ?>"><span class="btn-label"><span class="icon icon-chevron-circle-left icon-lg icon-fw"></span></span> Back</a>
    </div>
    <h1 class="title-bar-title">
        <span class="d-ib"><span class="icon icon-c"></span> <b><?= Html::encode($this->title) ?></b></span>
    </h1>
    <p class="title-bar-description">
        <small>List of all applicant types</small>
    </p>
</div>
<div class="row gutter-xs">
    <div class="col-xs-12">
        <div class="panel panel-default">
            <div class="panel-heading">


                <a class="btn btn-sm btn-labeled arrow-success" href="<?= Url::to(['add-type']) ?>">
                    <span class="btn-label">
                        <span class="icon icon-plus icon-lg icon-fw"></span>
                    </span>
                    Create a new investigation type
                </a>

            </div>
            <?php Pjax::begin(['id' => 'company_index', 'enablePushState' => false, 'timeout' => 0, 'options' => ['class' => 'panel-body panel-collapse']]); ?>
            <div class="alert-container">
                <?= Alert::widget() ?>
            </div>
            <?php // $this->render('/search/_search', ['model' => $searchModel]); ?>
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'tableOptions' => ['class' => 'table table-hover table-striped  dataTable no-footer dtr-inline'],
                'summaryOptions' => ['class' => 'col-sm-6'],
                'options' => ['class' => 'row'],
                'layout'=>"<div class='col-sm-12'>{items}</div>\n{summary}{pager}",
                'columns' => [
                    [
                        'class' => SerialColumn::class
                    ],
                    'name',

                    [
                        'class' => 'yii\grid\ActionColumn',
                        'template' => '{edit}{delete}',
                        'contentOptions' => [
                            'width' => 100,
                        ],
                        'buttons' => [
                            'edit' => function ($url, $model) {
                                return Html::a('Edit', Url::to(['/wizard/company', 'id' => $model->id], true),
                                    [
                                        'class' => "btn btn-primary btn-xs",
                                        'title' => 'Edit',
                                        'aria-label' => "Edit",
                                        'data-pjax' => "0",
                                    ]
                                );
                            },
                            'delete' => function ($url, $model) {
                                return Html::a('To archive', Url::to(['/company/archive', 'id' => $model->id], true),
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
        </div>
    </div>
</div>