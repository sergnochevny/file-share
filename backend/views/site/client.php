<?php

/** @var \backend\models\User $user */

use sn\utilities\helpers\Url;

$user = Yii::$app->getUser()->getIdentity();
$company = $user->company;
?>
<div class="panel">
    <div class="panel-body p-a-lg">
        <div class="row">
            <div class="col-sm-6">
                <img src="<?= Url::to('@web/images/logo.png'); ?>" alt="Plan. Protect. Prosper." width="184">
            </div>
            <div class="col-sm-6">
            </div>
        </div>

        <?= $this->render('/investigation/partials/_list',
            ['searchModel' => $searchModel, 'dataProvider' => $dataProvider]) ?>
    </div>
</div>