<?php
/**
 * Copyright (c) 2017. AIT
 */

use ait\utilities\helpers\Url;
use common\widgets\Alert;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\search\UserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Admins';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="title-bar">
    <div class="title-bar-actions">
        <?= Html::a(Html::tag('span',
                Html::tag('span', '', ['class' => 'icon icon-chevron-circle-left icon-lg icon-fw']),
                ['class' => 'btn-label']) . ' Back', Url::previous(), ['class' => 'btn btn-labeled arrow-default']) ?>
    </div>
    <h1 class="title-bar-title">
        <span class="d-ib"><span class="icon icon-users"></span> <?= Html::encode($this->title) ?></span>
    </h1>
    <p class="title-bar-description">
        <small>All users</small>
    </p>
</div>

<div class="row gutter-xs">
    <div class="col-xs-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <?php if (\Yii::$app->user->can('wizard.admin')) : ?>
                    <?= Html::a(Html::tag('span', Html::tag('span', '', ['class' => 'icon icon-plus icon-lg icon-fw']),
                            ['class' => 'btn-label']) . ' Add a New Admin', Url::to(['/wizard/admin']),
                        ['class' => 'btn btn-sm btn-labeled arrow-success'])
                    ?>
                <?php endif; ?>
            </div>
            <div class="form-inline no-footer">

                <?php Pjax::begin([
                    'id' => 'admin_index',
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
                    'tableOptions' => [
                        'class' => "table table-hover table-striped",
                        'cellspacing' => "0",
                        'width' => "100%"
                    ],
                    'layout' => "<div>{items}</div>\n{summary}{pager}",
                    'columns' => [
                        [
                            'attribute' => 'first_name',
                            'headerOptions' => [
                                'class' => 'hidden-sm hidden-xs',
                            ],
                            'contentOptions' => [
                                'class' => 'hidden-sm hidden-xs',
                            ],
                        ],
                        [
                            'attribute' => 'last_name',
                            'headerOptions' => [
                                'class' => 'hidden-sm hidden-xs',
                            ],
                            'contentOptions' => [
                                'class' => 'hidden-sm hidden-xs',
                            ],
                        ],
                        [
                            'attribute' => 'phone_number',
                            'headerOptions' => [
                                'class' => 'hidden-sm hidden-xs',
                            ],
                            'contentOptions' => [
                                'class' => 'hidden-sm hidden-xs',
                            ],
                        ],
                        'email:email',
                        [
                            'attribute' => 'role',
                            'label' => 'Position Status',
                            'format' => 'html',
                            'headerOptions' => [
                                'width' => 120,
                                'class' => 'hidden-sm hidden-xs',
                            ],
                            'contentOptions' => [
                                'width' => 120,
                                'class' => 'hidden-sm hidden-xs',
                            ],
                            'value' => function ($model, $key, $index, $column) {
                                $suff = [
                                    'sadmin' => ['class' => 'success', 'label' => 'Super User'],
                                    'admin' => ['class' => 'warning', 'label' => 'Admin'],
                                ];
                                //workaround for rename client
                                $role = $model->{$column->attribute};
                                $value = $role;
                                if (isset($suff[$role])) {
                                    $value = '<span class="' . $suff[$role]['class'] . '-text" >' .
                                        $suff[$role]['label'] .
                                        '</span >';
                                }
                                return $value;
                            }
                        ],
                        [
                            'class' => 'yii\grid\ActionColumn',
                            'template' => '{edit}{delete}',
                            'contentOptions' => [
                                'width' => 120,
                            ],
                            'visibleButtons' => [
                                'edit' => \Yii::$app->user->can('wizard.admin'),
                                'delete' => \Yii::$app->user->can('admin.delete'),
                            ],
                            'buttons' => [
                                'edit' => function ($url, $model) {
                                    return Html::a(
                                        'Edit',
                                        Url::to(['/wizard/admin', 'id' => $model->id], true),
                                        [
                                            'class' => "btn btn-primary btn-xs",
                                            'title' => 'Edit',
                                            'aria-label' => "Edit",
                                            'data-pjax' => "0",
                                        ]
                                    );
                                },
                                'delete' => function ($url, $model) {
                                    return Html::a(
                                        'Remove',
                                        Url::to(['delete', 'id' => $model->id], true),
                                        [
                                            'class' => "btn btn-danger btn-xs",
                                            'title' => 'Remove',
                                            'aria-label' => "Remove",
                                            'data-confirm' => "Confirm user removal.",
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
</div>