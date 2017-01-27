<?php

use yii\helpers\Html;
use yii\widgets\ListView;
use yii\widgets\Pjax;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\FileSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->registerJsFile(YII_ENV_DEV ? '@web/js/file_search.js' : '@web/js/file_search.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);

$this->title = 'Files';
$this->params['breadcrumbs'][] = $this->title;
?>

<?php Pjax::begin(['id' => 'file_search', 'enablePushState' => false, 'scrollTo' => 0, 'timeout' => 0]); ?>

<?php if (Yii::$app->request->isAjax && Yii::$app->session->hasFlash('alert')): ?>
    <?= Alert::widget([
        'body' => ArrayHelper::getValue(Yii::$app->session->getFlash('alert'), 'body'),
        'options' => ArrayHelper::getValue(Yii::$app->session->getFlash('alert'), 'options'),
    ]) ?>
<?php endif ?>

<div class="file-index">

    <div class="title-bar">
        <div class="title-bar-actions">
            <a class="btn btn-labeled arrow-default" href="#">
                <span class="btn-label">
                    <span class="icon icon-chevron-circle-left icon-lg icon-fw"></span>
                </span>
                Back
            </a>
        </div>
        <h1 class="title-bar-title">
            <span class="d-ib"><span class="icon icon-save"></span><?= Html::encode($this->title) ?></span>
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
                        <?php $uploadForm = \backend\widgets\ActiveForm::begin(
                            [
                                'id' => "upload-file",
                                'method' => 'post',
                                'action' => 'file/upload',
                                'options' => ['data-pjax' => true]
                            ]
                        ); ?>
                        <?= Html::activeFileInput($uploadModel, 'name', [
                            'id' => "file",
                            'style' => "background-color: #fff;border-radius: 5px;display: block;margin: 10px auto 15px;padding: 5px;"
                        ]); ?>
                        <?= Html::submitButton(
                            '<span class="btn-label">
                                    <span class="icon icon-upload  icon-lg icon-fw"></span>
                                </span>Upload',
                            [
                                'id' => "send",
                                'class' => 'btn btn-sm btn-labeled  arrow-warning'
                            ]
                        ); ?>
                        <?php \backend\widgets\ActiveForm::end(); ?>

                        <div class="panel panel-body hidden" data-toggle="match-height" style="height: 84px;">
                            <h5>Loading...</h5>
                            <div class="progress progress-xs">
                                <div class="progress-bar progress-bar-indicating progress-bar-warning"
                                     role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"
                                     style="width: 100%">
                                    <!-- <span class="sr-only">60% Complete (success)</span>-->
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="file-list_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer">
                        <?php echo $this->render('_search', ['model' => $searchModel]); ?>
                        <div class="row">
                            <div class="col-sm-12">
                                <?= GridView::widget([
                                    'dataProvider' => $dataProvider,
                                    'summary' => $dataProvider->totalCount < 2 ? "" : "<div class='col-md-12 helper-counter'><div class='row'>Showing {begin} &mdash; {end} of {totalCount} items</div></div>",
                                    'layout' => "{items}\n<div align='left'>{summary}</div><div align='right'>{pager}</div>",

                                    'tableOptions' => [
                                        'id' => 'file-list',
                                        'class' => "table table-hover table-striped  dataTable no-footer dtr-inline",
                                        'role' => "grid",
                                        'aria-describedby' => "file-list_info",
                                        'cellspacing' => "0",
                                        'width' => "100%"
                                    ],
                                    'rowOptions' => [
                                        'role' => "row"
                                    ],
                                    'columns' => [
                                        [
                                            'attribute' => 'name',
                                            'format' => 'html',
                                            'value' => function ($model, $key, $index, $column) {
                                                $value = '<div class="file">';
                                                $value .= '  <a class="file-link" href="#" title="file-name.pdf">';
                                                $value .= '    <div class="file-thumbnail file-thumbnail-' . $model->type . '"></div>';
                                                $value .= '    <div class="file-info">';
                                                $value .= '        <span class="file-ext">' . $model->type . '</span>';
                                                $value .= '        <span class="file-name">' . $model->{$column->attribute} . '</span>';
                                                $value .= '    </div>';
                                                $value .= '  </a>';
                                                $value .= '  <button class="file-delete-btn delete" title="Delete" type="button">';
                                                $value .= '    <span class="icon icon-remove"></span>';
                                                $value .= '  </button >';
                                                $value .= '</div >';
                                                return $value;
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
                                                'style' => "width: 583px;",
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
                                        'size',
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

                                <table id="file-list"
                                       class="table table-hover table-striped  dataTable no-footer dtr-inline"
                                       role="grid" aria-describedby="file-list_info" style="width: 100%;"
                                       cellspacing="0" width="100%">
                                    <thead>
                                    <tr role="row">
                                        <th class="sorting" tabindex="0" aria-controls="file-list" rowspan="1"
                                            colspan="1" style="width: 117px;"
                                            aria-label="File: activate to sort column ascending">File
                                        </th>
                                        <th class="sorting_asc" tabindex="0" aria-controls="file-list" rowspan="1"
                                            colspan="1" style="width: 583px;" aria-sort="ascending"
                                            aria-label="Description: activate to sort column descending">Description
                                        </th>
                                        <th class="sorting" tabindex="0" aria-controls="file-list" rowspan="1"
                                            colspan="1" style="width: 102px;"
                                            aria-label="Date: activate to sort column ascending">Date
                                        </th>
                                        <th class="sorting" tabindex="0" aria-controls="file-list" rowspan="1"
                                            colspan="1" style="width: 75px;"
                                            aria-label="Size: activate to sort column ascending">Size
                                        </th>
                                        <th class="sorting_disabled" rowspan="1" colspan="1" style="width: 69px;"
                                            aria-label=""></th>
                                    </tr>
                                    </thead>
                                    <tbody>


                                    <tr role="row" class="odd">
                                        <td tabindex="0">
                                            <div class="file">
                                                <a class="file-link" href="#" title="file-name.pdf">
                                                    <div class="file-thumbnail file-thumbnail-pdf"></div>
                                                    <div class="file-info">
                                                        <span class="file-ext">pdf</span>
                                                        <span class="file-name">1file-name.</span>
                                                    </div>
                                                </a>
                                                <button class="file-delete-btn delete" title="Delete" type="button">
                                                    <span class="icon icon-remove"></span>
                                                </button>
                                            </div>
                                        </td>
                                        <td class="sorting_1">Lorem Ipsum is simply dummy text of the printing and
                                            typesetting industry.
                                        </td>
                                        <td><span class="label label-warning">10.03.2016</span></td>
                                        <td>124 Mb</td>
                                        <td><a class="btn btn-danger btn-xs" type="button" data-toggle="modal"
                                               data-target="#myDeleteFile">Delete</a></td>
                                    </tr>
                                    <tr role="row" class="even">
                                        <td tabindex="0">
                                            <div class="file">
                                                <a class="file-link" href="#" title="file-name.doc">
                                                    <div class="file-thumbnail file-thumbnail-doc"></div>
                                                    <div class="file-info">
                                                        <span class="file-ext">doc</span>
                                                        <span class="file-name">file-name.</span>
                                                    </div>
                                                </a>
                                                <button class="file-delete-btn delete" title="Delete" type="button">
                                                    <span class="icon icon-remove"></span>
                                                </button>
                                            </div>
                                        </td>
                                        <td class="sorting_1">Lorem Ipsum is simply dummy text of the printing and
                                            typesetting industry.
                                        </td>
                                        <td><span class="label label-warning">10.03.2016</span></td>
                                        <td>123 Mb</td>
                                        <td><a class="btn btn-danger btn-xs" type="button" data-toggle="modal"
                                               data-target="#myDeleteFile">Delete</a></td>
                                    </tr>
                                    <tr role="row" class="odd">
                                        <td tabindex="0">
                                            <div class="file">
                                                <a class="file-link" href="#" title="file-name.xls">
                                                    <div class="file-thumbnail file-thumbnail-xls"></div>
                                                    <div class="file-info">
                                                        <span class="file-ext">xls</span>
                                                        <span class="file-name">file-name.</span>
                                                    </div>
                                                </a>
                                                <button class="file-delete-btn delete" title="Delete" type="button">
                                                    <span class="icon icon-remove"></span>
                                                </button>
                                            </div>
                                        </td>
                                        <td class="sorting_1">Lorem Ipsum is simply dummy text of the printing and
                                            typesetting industry.
                                        </td>
                                        <td><span class="label label-warning">10.03.2016</span></td>
                                        <td>12 Mb</td>
                                        <td><a class="btn btn-danger btn-xs" type="button" data-toggle="modal"
                                               data-target="#myDeleteFile">Delete</a></td>
                                    </tr>
                                    <tr role="row" class="even">
                                        <td tabindex="0">
                                            <div class="file">
                                                <a class="file-link" href="#" title="file-name.pdf">
                                                    <div class="file-thumbnail file-thumbnail-pdf"></div>
                                                    <div class="file-info">
                                                        <span class="file-ext">pdf</span>
                                                        <span class="file-name">file-name.</span>
                                                    </div>
                                                </a>
                                                <button class="file-delete-btn delete" title="Delete" type="button">
                                                    <span class="icon icon-remove"></span>
                                                </button>
                                            </div>
                                        </td>
                                        <td class="sorting_1">Lorem Ipsum is simply dummy text of the printing and
                                            typesetting industry.
                                        </td>
                                        <td><span class="label label-warning">10.03.2016</span></td>
                                        <td>124 Mb</td>
                                        <td><a class="btn btn-danger btn-xs" type="button" data-toggle="modal"
                                               data-target="#myDeleteFile">Delete</a></td>
                                    </tr>
                                    <tr role="row" class="odd">
                                        <td tabindex="0">
                                            <div class="file">
                                                <a class="file-link" href="#" title="file-name.zip">
                                                    <div class="file-thumbnail file-thumbnail-zip"></div>
                                                    <div class="file-info">
                                                        <span class="file-ext">zip</span>
                                                        <span class="file-name">file-name.</span>
                                                    </div>
                                                </a>
                                                <button class="file-delete-btn delete" title="Delete" type="button">
                                                    <span class="icon icon-remove"></span>
                                                </button>
                                            </div>
                                        </td>
                                        <td class="sorting_1">Lorem Ipsum is simply dummy text of the printing and
                                            typesetting industry.
                                        </td>
                                        <td><span class="label label-warning">08.03.2016</span></td>
                                        <td>126 Mb</td>
                                        <td><a class="btn btn-danger btn-xs" type="button" data-toggle="modal"
                                               data-target="#myDeleteFile">Delete</a></td>
                                    </tr>
                                    <tr role="row" class="even">
                                        <td tabindex="0">
                                            <div class="file">
                                                <a class="file-link" href="#" title="file-name.*">
                                                    <div class="file-thumbnail file-thumbnail-att"></div>
                                                    <div class="file-info">
                                                        <span class="file-ext">*</span>
                                                        <span class="file-name">file-name.</span>
                                                    </div>
                                                </a>
                                                <button class="file-delete-btn delete" title="Delete" type="button">
                                                    <span class="icon icon-remove"></span>
                                                </button>
                                            </div>
                                        </td>
                                        <td class="sorting_1">Lorem Ipsum is simply dummy text of the printing and
                                            typesetting industry.
                                        </td>
                                        <td><span class="label label-warning">15.03.2016</span></td>
                                        <td>162 Mb</td>
                                        <td><a class="btn btn-danger btn-xs" type="button" data-toggle="modal"
                                               data-target="#myDeleteFile">Delete</a></td>
                                    </tr>
                                    <tr role="row" class="odd">
                                        <td tabindex="0">
                                            <div class="file">
                                                <a class="file-link" href="images/temp/0310728269.jpg"
                                                   title="0310728269.jpg" download="0310728269.jpg">
                                                    <div class="file-thumbnail"
                                                         style="background-image: url(images/temp/0310728269.jpg)"></div>
                                                    <div class="file-info">
                                                        <span class="file-ext">jpg</span>
                                                        <span class="file-name">0310728269.</span>
                                                    </div>
                                                </a>
                                                <button class="file-delete-btn delete" title="Delete" type="button">
                                                    <span class="icon icon-remove"></span>
                                                </button>
                                            </div>
                                        </td>
                                        <td class="sorting_1">Lorem Ipsum is simply dummy text of the printing and
                                            typesetting industry.
                                        </td>
                                        <td><span class="label label-warning">13.03.2016</span></td>
                                        <td>712 Mb</td>
                                        <td><a class="btn btn-danger btn-xs" type="button" data-toggle="modal"
                                               data-target="#myDeleteFile">Delete</a></td>
                                    </tr>
                                    </tbody>
                                </table>


                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-5">
                                <div class="dataTables_info" id="file-list_info" role="status" aria-live="polite">
                                    Showing 1 to 7 of 7 entries
                                </div>
                            </div>
                            <div class="col-sm-7">
                                <div class="dataTables_paginate paging_simple_numbers" id="file-list_paginate">
                                    <ul class="pagination">
                                        <li class="paginate_button previous disabled" id="file-list_previous"><a
                                                    href="#" aria-controls="file-list" data-dt-idx="0"
                                                    tabindex="0">«</a></li>
                                        <li class="paginate_button active"><a href="#" aria-controls="file-list"
                                                                              data-dt-idx="1" tabindex="0">1</a></li>
                                        <li class="paginate_button next disabled" id="file-list_next"><a href="#"
                                                                                                         aria-controls="file-list"
                                                                                                         data-dt-idx="2"
                                                                                                         tabindex="0">»</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php Pjax::end(); ?>
</div>
