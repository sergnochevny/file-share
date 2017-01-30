<?php use common\widgets\Menu; ?>
<div class="profile">
    <div class="profile-header">
        <div class="profile-cover">
            <div class="profile-container">
                <div class="profile-card">
                    <div class="profile-avetar">
                        <img class="profile-avetar-img" src="<?=\yii\helpers\Url::to('@web/images/firmLogo.png',true);?>" alt="Company name" width="128" height="128">
                    </div>
                    <div class="profile-overview">
                        <h1 class="profile-name"><?= $model->name ?></h1>
                        <p><?php /* $model->description */ ?></p>
                    </div>
                    <div class="profile-info">
                        <ul class="profile-nav">
                            <li>
                                <div>
                                    <h3 class="profile-nav-heading">1</h3>
                                    <em>
                                        <small class="badge badge-warning">Active</small>
                                    </em>
                                </div>
                            </li>
                            <li>
                                <div>
                                    <h3 class="profile-nav-heading">2</h3>
                                    <em>
                                        <small class="badge badge-danger">Cancelled</small>
                                    </em>
                                </div>
                            </li>
                            <li>
                                <div>
                                    <h3 class="profile-nav-heading">87</h3>
                                    <em>
                                        <small class="badge badge-success">Arhives</small>
                                    </em>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="profile-tabs">
                    <?= Menu::widget([
                        'options' => ['class' => 'profile-nav'],
                        'items' => [[
                            'label' => 'Applicants',
                            'url' => ''
                        ],[
                            'label' => 'History',
                            'url' => ''
                        ],[
                            'label' => 'Files',
                            'url' => ''
                        ]]
                    ]) ?>
                </div>
            </div>
        </div>
    </div>
</div>