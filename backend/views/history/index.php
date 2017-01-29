<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel backend\models\CompanySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Companies';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="title-bar">
    <div class="title-bar-actions">
        <?= Html::a(Html::tag('span', Html::tag('span', '', ['class' => 'icon icon-chevron-circle-left icon-lg icon-fw']), ['class' => 'btn-label']) . ' Back', Url::previous(), ['class' => 'btn btn-labeled arrow-default']) ?>
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
                <?= Html::a(Html::tag('span', Html::tag('span', '', ['class' => 'icon icon-plus icon-lg icon-fw']), ['class' => 'btn-label']) . ' Create a new company', Url::to(['/wizard/company']), ['class' => 'btn btn-sm btn-labeled arrow-success']) ?>
            </div>
            <?php Pjax::begin(['options' => ['class' => 'panel-body panel-collapse']]); ?>
            <?= $this->render('partials/_search', ['model' => $searchModel]); ?>
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
                'layout'=>"<div class='col-sm-12'>{items}</div>\n{summary}{pager}",
                'columns' => [
                    'name',
                    'address',
                    'city',
                    'state',
                    'zip',
                    // 'status',
                    // 'created_at',
                    // 'updated_at',
                    ['class' => 'yii\grid\ActionColumn'],
                ],
            ]); ?>
            <?php Pjax::end(); ?>
        </div>
    </div>
</div>