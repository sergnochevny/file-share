<?php

use backend\widgets\ActiveForm;
use yii\bootstrap\Alert;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\widgets\ListView;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\FileSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->registerJsFile(YII_ENV_DEV ? '@web/js/file_search.js' : '@web/js/file_search.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);

$this->title = 'Files';
$this->params['breadcrumbs'][] = $this->title;
?>

<?php Pjax::begin(['id' => 'file_search', 'enablePushState' => false, 'timeout' => 0]); ?>

<?php if (Yii::$app->request->isAjax && Yii::$app->session->hasFlash('alert')): ?>
    <?= Alert::widget([
        'body' => ArrayHelper::getValue(Yii::$app->session->getFlash('alert'), 'body'),
        'options' => ArrayHelper::getValue(Yii::$app->session->getFlash('alert'), 'options'),
    ]) ?>
<?php endif ?>

<div class="title-bar">
    <div class="title-bar-actions">
        <?= Html::a(Html::tag('span', Html::tag('span', '', ['class' => 'icon icon-chevron-circle-left icon-lg icon-fw']), ['class' => 'btn-label']) . ' Back', Url::previous(), ['class' => 'btn btn-labeled arrow-default']) ?>
    </div>
    <h1 class="title-bar-title">
        <span class="d-ib"><span class="icon icon-save"></span> <?= Html::encode($this->title) ?></span>
    </h1>
    <p class="title-bar-description">
        <small>All files</small>
    </p>
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
                    <?php $uploadForm = ActiveForm::begin(
                        [
                            'id' => "upload-file",
                            'method' => 'post',
                            'action' => Url::to(['/file/upload'], true),
                            'options' => [
                                'data-pjax' => true,
                                'class' => 'text-center',
                                'enctype' => 'multipart/form-data'
                            ]
                        ]
                    ); ?>
                    <?= $uploadForm->field($uploadModel, 'file')->fileInput(['id' => "file"])->label(false); ?>
                    <?= Html::submitButton('<span class="btn-label"><span class="icon icon-upload  icon-lg icon-fw"></span></span>Upload',[
                        'id' => "send",
                        'class' => 'btn btn-sm btn-labeled arrow-warning send-file-button'
                    ]); ?>
                    <?php \backend\widgets\ActiveForm::end(); ?>
                    <div class="panel panel-body" data-toggle="match-height">
                        <h5>Success progress bar</h5>
                        <div class="progress progress-xs">
                            <div class="progress-bar progress-bar-indicating progress-bar-warning" role="progressbar"
                                 aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 60%">
                            </div>
                        </div>
                    </div>
                </div>
                <div id="file-list_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer">
                    <?php $this->render('partials/_search', ['model' => $searchModel]); ?>

                    <?= GridView::widget([
                        'dataProvider' => $dataProvider,
                        'tableOptions' => [
                            'id' => 'file-list',
                            'class' => "table table-hover table-striped dataTable",
                            'role' => "grid",
                            'aria-describedby' => "file-list_info",
                            'cellspacing' => "0",
                            'width' => "100%"
                        ],
                        'summaryOptions' => ['class' => 'col-sm-6'],
                        'pager' => [
                            'options' => [
                                'class' => 'col-sm-6',
                            ]
                        ],
                        'options' => ['class' => 'row'],
                        'layout'=>"<div class='col-sm-12'>{items}</div>\n{summary}{pager}",
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

                                    $button = Html::button(
                                        Html::tag('span', Html::tag('span', '', ['class' => 'icon icon-remove']), [
                                            'class' => 'file-delete-btn delete',
                                            'title' => 'Delete',
                                        ])
                                    );
                                    return Html::tag('div',
                                        Html::a($image, Url::to(['/file/download', 'id' => $model->citrix_id], true), [
                                            'class' => 'file-link',
                                            'title' => $model->{$column->attribute},
                                            'file-link' => '#'
                                        ]) . $button,
                                        ['class' => 'file']
                                    );
                                },
                                'headerOptions' => [
                                    'class' => "sorting",
                                    'tabindex' => "0",
                                    'rowspan' => "1",
                                    'colspan' => "1",
                                ]
                            ],
                            [
                                'attribute' => 'description',
                                'headerOptions' => [
                                    'tabindex' => "0",
                                    'aria-controls' => "file-list",
                                    'rowspan' => "1",
                                    'colspan' => "1",
                                ]
                            ],
                            [
                                'attribute' => 'created_at',
                                'format' => 'html',
                                'value' => function ($model, $key, $index, $column) {
                                    $value = '<span class="label label-warning" >' . date('m.d.Y', $model->{$column->attribute}) . '</span >';
                                    return $value;
                                }
                            ],
                            [
                                'attribute' => 'size',
                                'value' => function ($model, $key, $index, $column) {
                                    return Yii::$app->formatter->asSize($model->{$column->attribute}, 0, [], []);
                                }
                            ],
                            [
                                'class' => 'yii\grid\ActionColumn',
                                'template' => '{delete}',
                                'buttons' => [
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
                                ],
                            ],
                        ],
                    ]) ?>

                </div>
            </div>
        </div>
    </div>
</div>

<?php Pjax::end(); ?>
