<?php

/* @var $this \yii\web\View */

use common\helpers\Url;
use common\widgets\Alert;
use yii\widgets\Pjax;
use yii\web\JqueryAsset;


$activeClass = ' active';
$companyActive = isset($isCompany) ? $activeClass : '';
$userActive = isset($isUser) ? $activeClass : '';
$investigationActive = isset($isInvestigation) ? $activeClass : '';
$isUpdate = isset($isUpdate) ? $isUpdate : false;

$this->registerJsFile('@web/js/wizard.js', ['depends' => JqueryAsset::class]);
\yii\jui\JuiAsset::register($this);
$this->title = 'Wizard';

?>
<div class="row">
    <?php Pjax::begin(['id' => 'wizard-container', 'options' => ['class' => 'col-sm-12'], 'enablePushState' => false, 'timeout' => 0]); ?>
        <?= Alert::widget() ?>
        <div class="row gutter-xs">
            <div class="col-xs-12">
                <div class="panel">
                    <div class="panel-body panel-collapse">
                        <div align="center">
                            <h1>
                                <span class="d-ib"><i class="fa fa-magic" aria-hidden="true"></i>Protus3 Wizard Form</span>
                            </h1>

                            <p>
                                <small>Add and edit Company, Users and Applicants</small>
                            </p>
                        </div>

                        <div class="demo-form-wrapper">
                            <div id="demo-form-wizard-1" class="form form-horizontal">
                                <hr/>
                                <ul class="steps">
                                    <li class="step col-xs-4<?= $companyActive ?>">
                                        <a class="step-segment" href="<?= Url::to(['company'], true) ?>">
                                            <span class="step-icon icon icon-contao"></span>
                                        </a>

                                        <div class="step-content">
                                            <strong class="hidden-xs">Company</strong>
                                        </div>
                                    </li>
                                    <li class="step col-xs-4<?= $userActive ?>">
                                        <a class="step-segment" href="<?= Url::to(['user'], true) ?>">
                                            <span class="step-icon icon icon-users"></span>
                                        </a>

                                        <div class="step-content">
                                            <strong class="hidden-xs">Users</strong>
                                        </div>
                                    </li>
                                    <li class="step col-xs-4<?= $investigationActive ?>">
                                        <a class="step-segment" href="<?= Url::to(['investigation'], true) ?>">
                                            <span class="step-icon icon icon-folder-open-o"></span>
                                        </a>

                                        <div class="step-content">
                                            <strong class="hidden-xs">Applicants</strong>
                                        </div>
                                    </li>
                                </ul>
                                <hr/>
                                <div class="tab-content">

                                    <?php
                                    if ($companyActive) {
                                        echo $this->render('partials/_tab-company', compact('companyForm', 'selected', 'isUpdate', 'investigationTypes'));
                                    } else if ($userActive) {
                                        echo $this->render('partials/_tab-user', compact('userForm', 'selectedUser', 'isUpdate'));
                                    } else if ($investigationActive) {
                                        echo $this->render('partials/_tab-investigation', compact('investigationForm', 'isUpdate'));
                                    }
                                    ?>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php \yii\widgets\Pjax::end() ?>
</div>
