<?php

use ait\auth\widgets\Menu;
use ait\utilities\helpers\Url;
?>
<div class="profile">
    <div class="profile-header">
        <div class="profile-cover">
            <div class="profile-container">
                <div class="profile-card">
                    <div class="profile-overview">
                        <h1 class="profile-name"><?= $model->name ?></h1>
                        <p><?php $model->description ?></p>
                    </div>
                <div class="profile-tabs">
                    <?= Menu::widget([
                        'options' => ['class' => 'profile-nav'],
                        'items' => [[
                            'label' => 'Applicants',
                            'url' => Url::to(['/investigation/index'],true)
                        ],[
                            'label' => 'History',
                            'url' => Url::to(['/history/index'],true)
                        ],[
                            'label' => 'Files',
                            'url' => Url::to(['/file/index'],true)
                        ]]
                    ]) ?>
                </div>
            </div>
        </div>
    </div>
</div>