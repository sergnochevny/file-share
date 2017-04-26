<?php

/* @var $this \yii\web\View */

use common\helpers\Url;
use common\widgets\Alert;
use yii\widgets\Pjax;
use yii\web\JqueryAsset;
use backend\models\User;


$activeClass = ' active';
$companyActive = isset($isCompany) ? $activeClass : '';
$userActive = isset($isUser) ? $activeClass : '';
$investigationActive = isset($isInvestigation) ? $activeClass : '';
$isUpdate = isset($isUpdate) ? $isUpdate : false;

$col_xs_x = User::isSuperAdmin() ? 'col-xs-4' : 'col-xs-6';

//@todo consider to move in css file
$this->registerCss('.investigation-types label {display: block;}');
\backend\assets\WizardAsset::register($this);
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
                                <span class="d-ib"><i class="fa fa-magic" aria-hidden="true"></i><?=
                                    User::isClient() ? 'Background Investigation Request' : 'Protus3 Wizard Form'
                                ?></span>
                            </h1>

                            <p>
                                <?php if (User::isSuperAdmin()): ?>
                                <small>Add and edit Company, Users and Applicants</small>

                                <?php elseif (User::isAdmin()): ?>
                                <small>Add and edit Company and Users</small>

                                <?php endif ?>
                            </p>
                        </div>

                        <div class="demo-form-wrapper">
                            <div id="demo-form-wizard-1" class="form form-horizontal">
                                <hr/>
                                <ul class="steps">
                                    <li class="step <?= $col_xs_x ?><?= $companyActive ?>">
                                        <a class="step-segment" href="<?= Url::to(['company'], true) ?>">
                                            <span class="step-icon icon icon-contao"></span>
                                        </a>

                                        <div class="step-content">
                                            <strong class="hidden-xs">Company</strong>
                                        </div>
                                    </li>

                                    <?php if (!User::isClient()): ?>
                                    <li class="step <?= $col_xs_x ?><?= $userActive ?>">
                                        <a class="step-segment" href="<?= Url::to(['user'], true) ?>">
                                            <span class="step-icon icon icon-users"></span>
                                        </a>

                                        <div class="step-content">
                                            <strong class="hidden-xs">Users</strong>
                                        </div>
                                    </li>
                                    <?php endif ?>

                                    <?php if (!User::isAdmin()): ?>
                                    <li class="step <?= $col_xs_x ?><?= $investigationActive ?>">
                                        <a class="step-segment" href="<?= Url::to(['investigation'], true) ?>">
                                            <span class="step-icon icon icon-folder-open-o"></span>
                                        </a>

                                        <div class="step-content">
                                            <strong class="hidden-xs">Applicants</strong>
                                        </div>
                                    </li>
                                    <?php endif ?>
                                </ul>
                                <hr/>
                                <div class="tab-content">

                                    <?php
                                    if ($companyActive) {
                                        echo $this->render('partials/_tab-company', compact('companyForm', 'selected', 'isUpdate', 'investigationTypes'));
                                    } else if ($userActive && !User::isClient()) {
                                        echo $this->render('partials/_tab-user', compact('userForm', 'selectedUser', 'isUpdate'));
                                    } else if ($investigationActive && !User::isAdmin()) {
                                        echo $this->render('partials/_tab-investigation', compact('investigationForm', 'isUpdate', 'investigationTypes'));
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
