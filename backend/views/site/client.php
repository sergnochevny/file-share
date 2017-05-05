<?php
use common\helpers\Url;

/** @var \backend\models\User $user */
$user = Yii::$app->getUser()->getIdentity();
$company = $user->company;
?>
<div class="panel">
    <div class="panel-body p-a-lg">
        <div class="row">
            <div class="col-sm-6">
                <img src="<?= Url::to('@web/images/logo.png'); ?>" alt="Plan. Protect. Prosper."
                     width="184">

            </div>
            <div class="col-sm-6">
                <!--<div class="p-a">
                    <strong><?/*= $user->first_name */?> <?/*= $user->last_name */?></strong>
                    <br> <?/*= $company->address */?> <?/*= $company->city*/?>, <?/*= $company->state */?> <?/*= $user->company->zip */?>
                    <br> <a href="tel:<?/*= $user->phone_number */?>"><?/*= $user->phone_number */?></a>
                </div>-->
            </div>
        </div>

        <?= $this->render('/investigation/partials/_list', ['searchModel' => $searchModel, 'dataProvider' => $dataProvider]) ?>
    </div>
</div>