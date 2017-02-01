<?php

use common\widgets\Menu;
use common\helpers\Url;

?>
<div class="layout-sidebar">
    <div class="layout-sidebar-backdrop"></div>
    <div class="layout-sidebar-body">
        <div class="custom-scrollbar">
            <nav id="sidenav" class="sidenav-collapse collapse">
                <?php
                $items = [];
                $items[] = ['label' => 'Navigation', 'options' => ['class' => 'sidenav-heading']];
                $items[] = ['label' => 'Home', 'url' => Url::to(['/site'],true), 'options' => ['icon' => 'icon-home']];
                if (Yii::$app->user->can('admin')) {
                    $items[] = ['label' => 'Companies', 'url' => ['/company'], 'options' => ['icon' => 'icon-contao']];
                }
                $items[] = ['label' => 'Applicants', 'url' => ['/investigation'], 'options' => ['icon' => 'icon-folder-open-o']];
                $items[] = ['label' => 'History', 'url' => ['/history'], 'options' => ['icon' => 'icon-history']];
                $items[] = ['label' => 'Files', 'url' => ['/file'], 'options' => ['icon' => 'icon-save']];
//                if (Yii::$app->user->can('admin')) {
                    $items[] = ['label' => 'Users', 'url' => ['/user'], 'options' => ['icon' => 'icon-users']];
//                }

                ?>
                <?= Menu::widget([
                    'options' => ['class' => 'sidenav'],
                    'itemOptions' => ['class' => 'sidenav-item'],
                    'linkTemplate' => '<a href="{url}"><span class="sidenav-icon icon {icon}"></span> <span class="sidenav-label">{label}</span></a>',
                    'items' => $items
                ]) ?>
            </nav>
        </div>
    </div>
</div>