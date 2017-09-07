<?php

/* @var $this \yii\web\View */

use ait\utilities\helpers\Url;
use backend\models\User;
use common\widgets\Alert;
use yii\widgets\Pjax;


$activeClass = ' active';
$companyActive = isset($isCompany) ? $activeClass : '';
$userActive = isset($isUser) ? $activeClass : '';
$adminActive = isset($isAdmin) ? $activeClass : '';
$investigationActive = isset($isInvestigation) ? $activeClass : '';
$isUpdate = isset($isUpdate) ? $isUpdate : false;

$col_xs_x = Yii::$app->user->can('sadmin') ? 'col-xs-3' : 'col-xs-6';

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
                                    <?php if (Yii::$app->user->can('wizard.company')): ?>
                                    <li class="step <?= $col_xs_x ?><?= $companyActive ?>">
                                        <a class="step-segment" href="<?= Url::to([
                                            '/wizard/company',
                                            'id' => !empty(Yii::$app->user->identity->company) ? Yii::$app->user->identity->company->id:null], true) ?>">
                                            <span class="step-icon icon icon-contao"></span>
                                        </a>

                                        <div class="step-content">
                                            <strong class="hidden-xs">Company</strong>
                                        </div>
                                    </li>
                                    <?php endif ?>


                                    <?php if (Yii::$app->user->can('wizard.user')): ?>
                                    <li class="step <?= $col_xs_x ?><?= $userActive ?>">
                                        <a class="step-segment" href="<?= Url::to(['/wizard/user'], true) ?>">
                                            <span class="step-icon icon icon-users"></span>
                                        </a>

                                        <div class="step-content">
                                            <strong class="hidden-xs">Users</strong>
                                        </div>
                                    </li>
                                    <?php endif ?>

                                    <?php if (Yii::$app->user->can('wizard.admin')): ?>
                                        <li class="step <?= $col_xs_x ?><?= $adminActive ?>">
                                            <a class="step-segment" href="<?= Url::to(['/wizard/admin'], true) ?>">
                                                <span class="step-icon icon icon-users"></span>
                                            </a>

                                            <div class="step-content">
                                                <strong class="hidden-xs">Admins</strong>
                                            </div>
                                        </li>
                                    <?php endif ?>

                                    <?php if (Yii::$app->user->can('wizard.investigation')): ?>
                                    <li class="step <?= $col_xs_x ?><?= $investigationActive ?>">
                                        <a class="step-segment" href="<?= Url::to(['/wizard/investigation'], true) ?>">
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
                                        echo $this->render('partials/_tab-user',
                                            compact('userForm', 'selectedUser', 'isUpdate'));

                                    } else if ($adminActive && Yii::$app->user->can('wizard.admin')) {
                                        echo $this->render('partials/_tab-admin', compact('userForm', 'selectedUser', 'isUpdate'));

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
    <?php Pjax::end() ?>
</div>
