<?php

use yii\bootstrap\Alert;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use yii\widgets\Pjax;

\backend\assets\WizardAsset::register($this);

$activeClass = ' active';
$companyActive = isset($isCompany) ? $activeClass : '';
$userActive = isset($isUser) ? $activeClass : '';
$investigationActive = isset($isInvestigation) ? $activeClass : '';

?>

<?php Pjax::begin(['id' => 'wizard-container', 'enablePushState' => false, 'timeout' => 0]); ?>

<?php if (Yii::$app->request->isAjax && Yii::$app->session->hasFlash('alert')): ?>
    <?= Alert::widget([
        'body' => ArrayHelper::getValue(Yii::$app->session->getFlash('alert'), 'body'),
        'options' => ArrayHelper::getValue(Yii::$app->session->getFlash('alert'), 'options'),
    ]) ?>
<?php endif ?>
<div class="row gutter-xs">
    <div class="col-xs-12">
        <div class="panel">
            <div class="panel-body panel-collapse">
                <div align="center">
                    <h1>
                        <span class="d-ib"><span class="icon icon-magic"></span>Wizard form</span>
                    </h1>

                    <p>
                        <small>Add and edit Company, Agents and Applicants</small>
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

                            <?php if ($companyActive): ?>
                                <?= $this->render('_tab-company', compact('companyForm','selected')) ?>
                            <?php elseif ($userActive): ?>
                                <?= $this->render('_tab-user', compact('userForm')) ?>
                            <?php elseif ($investigationActive): ?>
                                <?= $this->render('_tab-investigation', compact('investigationForm')) ?>
                            <?php endif ?>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php \yii\widgets\Pjax::end() ?>