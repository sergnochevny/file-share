<?php

/* @var $this yii\web\View */
/* @var $searchModel backend\models\InvestigationSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

use yii\helpers\Html;
use common\helpers\Url;

$this->title = 'Applicants';
$this->params['breadcrumbs'][] = $this->title;
?>
<?= !empty($company) ? $this->render('partials/_company', ['model' => $company]) : '' ?>
<div class="title-bar">
    <div class="title-bar-actions">
        <?= Html::a(Html::tag('span', Html::tag('span', '', ['class' => 'icon icon-chevron-circle-left icon-lg icon-fw']), ['class' => 'btn-label']) . ' Back', Url::previous(), ['class' => 'btn btn-labeled arrow-default']) ?>
    </div>
    <h1 class="title-bar-title">
        <span class="d-ib"><span class="icon icon-folder-open-o"></span> <?= Html::encode($this->title) ?></span>
    </h1>
    <p class="title-bar-description">
        <small>List of all applicants</small>
    </p>
</div>
<div class="row gutter-xs">
    <div class="col-xs-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <?= Html::a(Html::tag('span', Html::tag('span', '', ['class' => 'icon icon-plus icon-lg icon-fw']), ['class' => 'btn-label']) . ' Create a New Applicant', Url::to(['/wizard/investigation']), ['class' => 'btn btn-sm btn-labeled arrow-success']) ?>
            </div>
            <?= $this->render('partials/_list',
                [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider
                ]
            ); ?>
        </div>
    </div>
</div>