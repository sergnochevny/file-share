<?php

use backend\models\search\FileSearch;
use backend\widgets\ActiveForm;
use common\widgets\Alert;
use yii\helpers\Html;
use common\helpers\Url;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\search\FileSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

if (!empty($investigation)) {
    $this->title = Html::encode($investigation->company->name) . ' | Investigation View | ' . Html::encode($investigation->name);
    $this->params['breadcrumbs'][] = ['label' => 'Investigations', 'url' => ['index']];
    $this->params['breadcrumbs'][] = $this->title;
} else {
    $this->title = 'Files';
    $this->params['breadcrumbs'][] = $this->title;
}
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
            <small>General information about the investigation</small>
        <?php else : ?>
            <small>All files</small>
        <?php endif; ?>
    </p>
</div>
<?= !empty($investigation) ? $this->render('partials/_investigation', ['model' => $investigation]) : '' ?>

<?php Pjax::begin(['id' => 'file_index', 'enablePushState' => false, 'timeout' => 0]); ?>
<div class="alert-container">
    <?= Alert::widget() ?>
</div>
<div class="row gutter-xs">
    <div class="col-xs-12">
        <div class="panel">
            <div class="panel-body panel-collapse">
                <div class="text-center m-b">
                    <h3 class="m-b-0">All files</h3>
                    <small>All downloaded files that relate to the present case</small>
                    <br/>
                    <br/>
                    <?php
                    /**
                     * @var \common\models\Investigation $investigation
                     */
                    $url = (!empty($investigation)) ?
                        Url::to(['/file/upload', 'parent' => $investigation->citrix_id], true) :
                        Url::to(['/file/upload'], true);
                    $uploadForm = ActiveForm::begin(
                        [
                            'id' => "upload-file",
                            'method' => 'post',
                            'action' => $url,
                            'options' => [
                                'data-pjax' => true,
                                'class' => 'text-center',
                                'enctype' => 'multipart/form-data'
                            ]
                        ]
                    ); ?>
                    <?php if (!empty($investigation) || Yii::$app->user->can('admin')): ?>
                        <?= $uploadForm->field($uploadModel, 'file')->fileInput(['id' => "file"])->label(false); ?>
                        <?= Html::submitButton('<span class="btn-label"><span class="icon icon-upload  icon-lg icon-fw"></span></span>Upload', [
                            'id' => "send",
                            'class' => 'btn btn-sm btn-labeled arrow-warning send-file-button'
                        ]); ?>
                    <?php endif; ?>

                    <?php
                    $this->registerJsFile(YII_ENV_DEV ? '@web/js/input_upload_submit.js' : '@web/js/input_upload_submit.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
                    \backend\widgets\ActiveForm::end();
                    ?>
                    <div class="panel panel-body" data-toggle="match-height">
                        <div class="progress progress-xs">
                            <div class="progress-bar progress-bar-indicating progress-bar-warning" role="progressbar"
                                 aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-inline no-footer">
                    <?= $this->render('/search/_search', ['model' => $searchModel]); ?>

                    <?= GridView::widget([
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
                                'attribute' => 'name',
                                'format' => 'html',
                                'value' => function ($model, $key, $index, $column) {
                                    $image = Html::tag('div', '', [
                                            'class' => 'file-thumbnail file-thumbnail-' . $model->type
                                        ]) . Html::tag('div',
                                            Html::tag('span', $model->type, ['class' => 'file-ext']) .
                                            Html::tag('span', $model->{$column->attribute}, ['class' => 'file-name']),
                                            ['class' => 'file-info']
                                        );
                                    return Html::tag('div',
                                        $image,
                                        ['class' => 'file']
                                    );
                                },
                                'headerOptions' => [
                                    'class' => 'hidden-sm hidden-xs sorting',
                                    'tabindex' => "0",
                                    'rowspan' => "1",
                                    'colspan' => "1",
                                ],
                                'contentOptions' => [
                                    'class' => 'hidden-sm hidden-xs sorting',
                                ]
                            ],
                            [
                                'attribute' => 'description',
                                'headerOptions' => [
                                    'tabindex' => "0",
                                    'rowspan' => "1",
                                    'colspan' => "1",
                                    'class' => 'hidden-sm hidden-xs',
                                ],
                                'contentOptions' => [
                                    'class' => 'hidden-sm hidden-xs',
                                ],
                            ],
                            [
                                'attribute' => 'created_at',
                                'contentOptions' => [
                                    'class' => 'hidden-sm hidden-xs',
                                    'width' => 80
                                ],
                                'format' => 'html',
                                'value' => function ($model, $key, $index, $column) {
                                    $value = '<span class="label label-warning" >' . Yii::$app->formatter->asDate($model->{$column->attribute}) . '</span >';
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
                                'template' => '{delete}{download}',
                                'contentOptions' => [
                                    'width' => 150
                                ],
                                'buttons' => [
                                    'delete' => function ($url, $model) use ($investigation) {
                                        $content = '';
                                        if (Yii::$app->user->can('admin') ||
                                            (
                                                !Yii::$app->user->can('admin') &&
                                                !empty($investigation) &&
                                                Yii::$app->user->can('employee', ['investigation' => $investigation])
                                            )
                                        )
                                            $content = Html::a('To archive', Url::to(['/file/archive', 'id' => $model->id], true),
                                                [
                                                    'class' => "btn btn-danger btn-xs",
                                                    'title' => 'To archive',
                                                    'aria-label' => "To archive",
                                                    'data-confirm' => "Confirm removal",
                                                    'data-method' => "post",
                                                    'data-pjax' => "0",
                                                ]
                                            );
                                        return $content;
                                    },
                                    'download' => function ($url, $model) use ($investigation) {
                                        $content = '';
                                        if (Yii::$app->user->can('admin') ||
                                            (
                                                !Yii::$app->user->can('admin') &&
                                                ((!empty($investigation) && Yii::$app->user->can('employee', ['investigation' => $investigation])) ||
                                                    (Yii::$app->user->can('employee', ['allfiles' => $model->parents->parent])))
                                            )
                                        )
                                            $content = Html::a('Download', Url::to(['/file/download', 'id' => $model->citrix_id], true),
                                                [
                                                    'class' => "btn btn-warning btn-xs",
                                                    'title' => 'Download',
                                                    'aria-label' => "Download",
                                                    'data-pjax' => "0",
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
            </div>
        </div>
    </div>
</div>

<?php Pjax::end(); ?>
