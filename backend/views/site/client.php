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
                <div class="p-a">
                    <strong>Protus 3</strong>
                    <br> 2366 Noriega St 726 XXXX New York, NY 10007 United States of America
                    <br> <a href="tel:+1 234-56789-0123">+1 234-56789-0123</a>
                </div>
            </div>
            <div class="col-sm-6">
                <i class="icon icon-user icon-6x"></i>
                <div class="p-a">
                    <strong><?= $user->first_name ?> <?= $user->last_name ?></strong>
                    <br> <?= $company->address ?> <?= $company->city?>, <?= $company->state ?> <?= $user->company->zip ?>
                    <br> <a href="tel:<?= $user->phone_number ?>"><?= $user->phone_number ?></a>
                </div>
            </div>
        </div>

        <?= $this->render('/investigation/partials/_list', ['searchModel' => $searchModel, 'dataProvider' => $dataProvider]) ?>
    </div>
</div>