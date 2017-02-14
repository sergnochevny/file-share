<?php
/** @var $stat \backend\models\Statistics */
/** @var $this \yii\web\View */

use yii\widgets\ActiveForm;
use yii\helpers\Html;

$this->registerJs("$(document).on('change', '#date-range-selector', function () {
        console.log('hello');
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
                        <h3 class="media-heading">
                            <span class="fw-l"><?= $stat->allApplicants ?></span>
                            <!--<span class="fw-b fz-sm text-danger">
                                <span class="icon icon-caret-up"></span>
                                15%
                            </span>-->
                        </h3>
                        <small><?= $stat->pendingApplicants ?> applicant are pending</small>
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


<!--<div class="row gutter-xs">
    <div class="col-xs-12 col-md-6">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Income / Expenses</h4>
            </div>
            <div class="card-body">
                <div class="card-chart">
                    <canvas data-chart="line" data-animation="false"
                            data-labels='["Sun", "Mon", "Tue", "Wed", "Thu", "Fri", "Sat"]'
                            data-values='[{"label": "Income", "backgroundColor": "transparent", "borderColor": "#87764e", "pointBackgroundColor": "#87764e", "data": [29432, 20314, 17665, 22162, 31194, 35053, 29298]}, {"label": "Expenses", "backgroundColor": "transparent", "borderColor": "#da1021", "pointBackgroundColor": "#da1021", "data": [9956, 22607, 30963, 22668, 16338, 22222, 39238]}]'
                            data-tooltips='{"mode": "label"}' data-hide='["gridLinesX", "legend"]'
                            height="150"></canvas>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xs-12 col-md-6">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Pass / Failed</h4>
            </div>
            <div class="card-body">
                <div class="card-chart">
                    <canvas data-chart="bar" data-animation="false"
                            data-labels='["Sun", "Mon", "Tue", "Wed", "Thu", "Fri", "Sat"]'
                            data-values='[{"label": "Pass", "backgroundColor": "#87764e", "borderColor": "#87764e", "data": [3089, 2132, 1854, 2326, 3274, 3679, 3075]}, {"label": "Failed", "backgroundColor": "#da1021", "borderColor": "#da1021", "data": [983, 2232, 3057, 2238, 1613, 2194, 3874]}]'
                            data-tooltips='{"mode": "label"}' data-hide='["gridLinesX", "legend"]'
                            height="150"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>-->