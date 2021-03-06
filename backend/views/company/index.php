<?php

use sn\utilities\helpers\Url;
use common\widgets\Alert;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\search\CompanySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Companies';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="title-bar">
    <div class="title-bar-actions">
        <?= Html::a(Html::tag('span',
                Html::tag('span', '', ['class' => 'icon icon-chevron-circle-left icon-lg icon-fw']),
                ['class' => 'btn-label']) . ' Back', Url::previous(), ['class' => 'btn btn-labeled arrow-default']) ?>
    </div>
    <h1 class="title-bar-title">
        <span class="d-ib"><span class="icon icon-contao"></span> <b><?= Html::encode($this->title) ?></b></span>
    </h1>
    <p class="title-bar-description">
        <small>List of all company accounts</small>
    </p>
</div>
<div class="row gutter-xs">
    <div class="col-xs-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <?= Html::a(Html::tag('span',
                        Html::tag('span', '', ['class' => 'icon icon-plus icon-lg icon-fw']),
                        ['class' => 'btn-label']) . ' Create a new company', Url::to(['/wizard/company']),
                    ['class' => 'btn btn-sm btn-labeled arrow-success']) ?>
            </div>
            <?php Pjax::begin([
                'id' => 'company_index',
                'enablePushState' => false,
                'timeout' => 0,
                'options' => ['class' => 'panel-body panel-collapse']
            ]); ?>
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
                    'name',
                    [
                        'attribute' => 'address',
                        'headerOptions' => ['class' => 'hidden-sm hidden-xs',],
                        'contentOptions' => ['class' => 'hidden-sm hidden-xs',],
                    ],
                    [
                        'attribute' => 'city',
                        'headerOptions' => ['class' => 'hidden-sm hidden-xs',],
                        'contentOptions' => ['class' => 'hidden-sm hidden-xs',],
                    ],
                    [
                        'attribute' => 'state',
                        'headerOptions' => ['class' => 'hidden-sm hidden-xs',],
                        'contentOptions' => ['class' => 'hidden-sm hidden-xs',],
                    ],
                    [
                        'attribute' => 'zip',
                        'headerOptions' => ['class' => 'hidden-sm hidden-xs',],
                        'contentOptions' => ['class' => 'hidden-sm hidden-xs',],
                    ],
                    [
                        'class' => 'yii\grid\ActionColumn',
                        'template' => '{edit}{delete}',
                        'contentOptions' => ['width' => 100,],
                        'visibleButtons' => [
                            'edit' => \Yii::$app->user->can('wizard.company'),
                            'archive' => \Yii::$app->user->can('company.archive'),
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
                                return Html::a('Archive', Url::to(['/company/archive', 'id' => $model->id], true),
                                    [
                                        'class' => "btn btn-purple btn-xs",
                                        'title' => 'Archive',
                                        'aria-label' => "Archive",
                                        'data-confirm' => "Confirm removal",
                                        'data-method' => "post",
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