<?php
/** @var $stat \backend\models\Statistics */
/** @var $graph \backend\models\Graph */
/** @var $this \yii\web\View */

use yii\widgets\ActiveForm;
use yii\helpers\Html;

$this->registerJs("$(document).on('change', '#date-range-selector', function () {
        $(this).closest('form').trigger('submit');
    });", \yii\web\View::POS_READY);
?>
<div class="title-bar">
    <div class="title-bar-actions">
        <?php $form = ActiveForm::begin() ?>

        <?= Html::activeDropDownList($stat, 'dateRange', $stat->dateRangeList, [
            'class' => 'selectpicker dropdown',
            'id' => 'date-range-selector'
        ]) ?>

        <?php ActiveForm::end() ?>
    </div>
    <h1 class="title-bar-title">
        <span class="d-ib"><span class="icon icon-home"></span> Home</span>
    </h1>
    <p class="title-bar-description">
        <small>Extended statistics for all projects</small>
    </p>
</div>


<div class="row gutter-xs">
    <div class="col-md-4">
        <div class="card">
            <div class="card-body">
                <div class="media">
                    <div class="media-middle media-left">
                        <span class="bg-gray sq-64 circle"><span class="icon icon-flag"></span></span>
                    </div>
                    <div class="media-middle media-body">
                        <h2 class="media-heading">
                            <span class="fw-l"><?= $stat->allApplicants ?></span>
                            <small>
                                <?= Yii::t('app', '{n, plural, =1{Applicant} other{Applicants}}', [
                                        'n' => $stat->allApplicants
                                ]) ?>

                            </small>
                        </h2>
                        <small>
                            <?=  Yii::t('app', '{n, plural, =1{# applicant is} other{# applicants are}} pending', [
                                'n' => $stat->pendingApplicants,
                            ]) ?>
                        </small>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card">
            <div class="card-body">
                <div class="media">
                    <div class="media-middle media-left">
                        <div class="media-chart">
                            <canvas data-chart="doughnut" data-animation="false"
                                    data-labels='["Completed", "In Progress"]'
                                    data-values='[{"backgroundColor": ["#431f4d", "#ffffff"], "borderColor": ["#292929", "#292929"], "data": [<?= $stat->completedApplicants ?>, <?= $stat->allApplicants ?: 1 ?>]}]'
                                    data-hide='["legend", "scalesX", "scalesY", "tooltips"]' height="64"
                                    width="64"></canvas>
                        </div>
                    </div>
                    <div class="media-middle media-body">
                        <h2 class="media-heading">
                            <span class="fw-l"><?= $stat->completedApplicants ?></span>
                            <small>Completed</small>
                        </h2>
                        <small>
                            <?= $stat->countPercentage($stat->completedApplicants) ?>% completed applicants
                        </small>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card">
            <div class="card-body">
                <div class="media">
                    <div class="media-middle media-left">
                        <div class="media-chart">
                            <canvas data-chart="doughnut" data-animation="false"
                                    data-labels='["Completed", "In Progress"]'
                                    data-values='[{"backgroundColor": ["#431f4d", "#ffffff"], "borderColor": ["#292929", "#292929"], "data": [<?= $stat->activeApplicants ?>, <?= $stat->allApplicants ?: 1 ?>]}]'
                                    data-hide='["legend", "scalesX", "scalesY", "tooltips"]' height="64"
                                    width="64"></canvas>
                        </div>
                    </div>
                    <div class="media-middle media-body">
                        <h2 class="media-heading">
                            <span class="fw-l"><?= $stat->activeApplicants ?></span>
                            <small>In Progress</small>
                        </h2>
                        <small>
                            <?= $stat->countPercentage($stat->activeApplicants) ?>% applicants in progress
                        </small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="row gutter-xs">
    <div class="col-xs-12">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">New Applicants For The Last 30 Days</h4>
            </div>
            <div class="card-body">
                <div class="card-chart">
                    <canvas data-chart="line" data-animation="false"
                            data-labels='<?= json_encode(array_keys($graph->getDataForGraph())) ?>'
                            data-values='[{"label": "New Applicants", "backgroundColor": "transparent", "borderColor": "#87764e", "pointBackgroundColor": "#87764e", "data": <?= json_encode(array_values($graph->getDataForGraph())) ?>}]'
                            data-tooltips='{"mode": "label"}' data-hide='["gridLinesX", "legend"]'
                            height="100px"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>