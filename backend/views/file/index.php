<?php

use backend\models\FileUpload;
use backend\models\User;
use backend\widgets\ActiveForm;
use common\widgets\Alert;
use yii\helpers\Html;
use common\helpers\Url;
use yii\grid\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\search\FileSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

if (!empty($investigation)) {
    $this->title = Html::encode($investigation->company->name) . ' | Investigation View | ' . Html::encode($investigation->name);
    $this->params['breadcrumbs'][] = ['label' => 'Investigations', 'url' => ['index']];
    $this->params['breadcrumbs'][] = $this->title;
} else {
    $this->title = 'Forms & Templates';
    $this->params['breadcrumbs'][] = $this->title;
}

$view = $this;
?>
<div class="title-bar">

    <div class="title-bar-actions">
        <?= Html::a(Html::tag('span', Html::tag('span', '', ['class' => 'icon icon-chevron-circle-left icon-lg icon-fw']), ['class' => 'btn-label']) . ' Back', Url::previous(), ['class' => 'btn btn-labeled arrow-default']) ?>
    </div>
    <h1 class="title-bar-title">
        <span class="d-ib"><span class="icon icon-save"></span> <?= Html::encode($this->title) ?></span>
    </h1>

    <p class="title-bar-description">
        <?php if (!empty($investigation)) : ?>
            <small>Applicant details</small>
        <?php endif ?>
    </p>
</div>

<div class="row gutter-xs">
    <div class="col-xs-12">
        <div class="panel">
            <div class="panel-body panel-collapse">
                <div class="text-center m-b">
                    <?php if (!empty($investigation)) : ?>
                        <h3 class="m-b-0">Files</h3>
                        <small>All files for this applicant</small>
                    <?php else : ?>
                        <h3 class="m-b-0">Forms and Templates</h3>
                    <?php endif; ?>

                    <br/>
                    <br/>
                    <?php
                    /**
                     * @var \common\models\Investigation $investigation
                     */
                    $url = (!empty($investigation)) ?
                        Url::to(['/file/multi-upload', 'parent' => $investigation->citrix_id], true) :
                        Url::to(['/file/multi-upload'], true);
                    ?>
                    <?php if (!empty($investigation) || Yii::$app->user->can('admin') || Yii::$app->user->can('superAdmin')): ?>
                        <?= $this->render('partials/_upload', ['model' => $uploadModel, 'action' => $url]) ?>
                    <?php endif; ?>
                </div>
                <?php Pjax::begin(['id' => 'file_index', 'enablePushState' => false, 'timeout' => false]); ?>
                <?= !empty($investigation) ? $this->render('partials/_investigation', ['model' => $investigation]) : '' ?>
                <div class="alert-container">
                    <?= Alert::widget() ?>
                </div>

                <div class="form-inline no-footer">
                    <?php
                    $action = empty($investigation) ?: Url::to([null, 'id' => $investigation->id]);
                    ?>
                    <?= $this->render('/search/_search', ['model' => $searchModel, 'action' => $action]); ?>

                    <?= GridView::widget([
                        'id' => 'files-grid',
                        'dataProvider' => $dataProvider,
                        'tableOptions' => [
                            'class' => "table table-hover table-striped",
                            'cellspacing' => "0",
                            'width' => "100%"
                        ],
                        'options' => ['class' => 'row'],
                        'layout' => "<div class='col-sm-12'>{items}</div>\n{summary}{pager}",
                        'columns' => [
                            [
                                'class' => 'yii\grid\CheckboxColumn',
                                'cssClass' => 'multi-download',
                                'options' => [
                                    'id' => 'selection-col',
                                    'data-download-url' => Url::to(['/file/multi-download'], true),
                                ]
                            ],
                            [
                                'attribute' => 'name',
                                'format' => 'html',
                                'value' => function ($model, $key, $index, $column) {
                                    $image = Html::tag('div', '', [
                                        'class' => 'file-thumbnail file-thumbnail-' . FileUpload::fileExt($model->type)
                                    ]);
                                    return Html::tag('div',
                                        $image,
                                        ['class' => 'file']
                                    );
                                },
                                'headerOptions' => [
                                    'class' => 'sorting',
                                    'tabindex' => "0",
                                    'rowspan' => "1",
                                    'colspan' => "1",
                                ],
                                'contentOptions' => [
                                    'class' => 'sorting',
                                ]
                            ],
                            'name:ntext:Name',
                            [
                                'attribute' => 'created_at',
                                'contentOptions' => [
                                    'class' => 'hidden-sm hidden-xs',
                                    'width' => 80
                                ],
                                'format' => 'html',
                                'value' => function ($model, $key, $index, $column) {
                                    $value = '<span class="" >' . Yii::$app->formatter->asDate($model->{$column->attribute}) . '</span >';
                                    return $value;
                                },
                                'headerOptions' => [
                                    'class' => 'hidden-sm hidden-xs',
                                ],
                            ],
                            [
                                'attribute' => 'size',
                                'value' => function ($model, $key, $index, $column) {
                                    return Yii::$app->formatter->asShortSize($model->{$column->attribute}, 0, [], []);
                                },
                                'headerOptions' => [
                                    'class' => 'hidden-sm hidden-xs',
                                ],
                                'contentOptions' => [
                                    'width' => 100,
                                    'class' => 'hidden-sm hidden-xs',
                                ],
                            ],
                            [
                                'class' => 'yii\grid\ActionColumn',
                                'template' => '{archive}{delete}{download}',
                                'contentOptions' => [
                                    'width' => (Yii::$app->user->can('admin') || Yii::$app->user->can('superAdmin')) ? 220 : 150
                                ],
                                'buttons' => [
                                    'archive' => function ($url, $model) use ($investigation, $view) {
                                        $content = '';
                                        if (Yii::$app->user->can('admin') || Yii::$app->user->can('superAdmin') ||
                                            (
                                                !Yii::$app->user->can('admin') && !Yii::$app->user->can('superAdmin') &&
                                                !empty($investigation) &&
                                                Yii::$app->user->can('employee', ['investigation' => $investigation])
                                            )
                                        )
                                            $content = Html::a(User::isClient() ? 'Remove' : 'Archive', Url::to(['/file/archive', 'id' => $model->id], true),
                                                [
                                                    'class' => "btn btn-purple btn-xs",
                                                    'title' => 'Archive',
                                                    'aria-label' => "Archive",
                                                    'data-confirm' => "Confirm archiving",
                                                    'data-method' => "post",
                                                    'data-pjax' => 1,
                                                ]
                                            );
                                        return $content;
                                    },
                                    'delete' => function ($url, $model) use ($investigation) {
                                        $content = '';
                                        if (Yii::$app->user->can('admin') || Yii::$app->user->can('superAdmin'))
                                            $content = Html::a('Delete', Url::to(['/file/delete', 'id' => $model->id], true),
                                                [
                                                    'class' => "btn btn-danger btn-xs",
                                                    'title' => 'Delete',
                                                    'aria-label' => "Delete",
                                                    'data-confirm' => "Confirm removal",
                                                    'data-method' => "post",
                                                    'data-pjax' => 1,
                                                ]
                                            );
                                        return $content;
                                    },
                                    'download' => function ($url, $model) use ($investigation) {
                                        $content = '';
                                        if (Yii::$app->user->can('admin') || Yii::$app->user->can('superAdmin') ||
                                            (
                                                !Yii::$app->user->can('admin') && !Yii::$app->user->can('superAdmin') &&
                                                ((!empty($investigation) && Yii::$app->user->can('employee', ['investigation' => $investigation])) ||
                                                    (Yii::$app->user->can('employee', ['allfiles' => $model->parents->parent])))
                                            )
                                        )
                                            $content = Html::a('Download', Url::to(['/file/download', 'id' => $model->citrix_id], true),
                                                [
                                                    'class' => "btn btn-warning btn-xs",
                                                    'data-download' => true,
                                                    'title' => 'Download',
                                                    'aria-label' => "Download",
                                                    'data-pjax' => 0,
                                                ]
                                            );
                                        return $content;
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
                    ]) ?>

                </div>
                <?php Pjax::end(); ?>
            </div>
        </div>
    </div>
</div>
<?php $this->registerJsFile('@web/js/file.multidownload.js', ['depends' => \common\assets\ExtLibAsset::className()]) ?>
<?php \backend\assets\AlertHelperAsset::register($this); ?>
<?php \backend\assets\DownloadAsset::register($this); ?>

