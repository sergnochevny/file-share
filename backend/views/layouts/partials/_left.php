<?php

use common\widgets\Menu;

?>
<div class="layout-sidebar">
    <div class="layout-sidebar-backdrop"></div>
    <div class="layout-sidebar-body">
        <div class="custom-scrollbar">
            <nav id="sidenav" class="sidenav-collapse collapse">
                <?php
                $items = [];
                $items[] = ['label' => 'Navigation', 'options' => ['class' => 'sidenav-heading']];
                $items[] = ['label' => 'Home', 'url' => ['/site/index'], 'options' => ['icon' => 'icon-home']];
                if(Yii::$app->user->can('admin')){
                    $items[] = ['label' => 'Companies', 'url' => ['/company/index'], 'options' => ['icon' => 'icon-contao']];
                } else {
                    $items[] = ['label' => 'My Company', 'url' => ['/company/view'], 'options' => ['icon' => 'icon-contao']];
                }
                $items[] = ['label' => 'Applicants', 'url' => ['/investigation/index'], 'options' => ['icon' => 'icon-folder-open-o']];
                $items[] = ['label' => 'History', 'url' => ['/history/index'], 'options' => ['icon' => 'icon-history']];
                $items[] = ['label' => 'Files', 'url' => ['/file/index'], 'options' => ['icon' => 'icon-save']];
                if(Yii::$app->user->can('admin')) {
                    $items[] = ['label' => 'Users', 'url' => ['/user/index'], 'options' => ['icon' => 'icon-users']];
                }

                ?>
                <?= Menu::widget(
                ['options' => ['class' => 'sidenav'],
                'itemOptions' => ['class' => 'sidenav-item'],
                'linkTemplate' => '<a href="{url}"><span class="sidenav-icon icon {icon}"></span> <span class="sidenav-label">{label}</span></a>',
                'items' => $items,]
                ) ?>
                <!--ul class="sidenav">
                    <li class="sidenav-item">
                        <a href="investigation.php">
                            <span class="badge badge-warning" title="Active">13</span>
                            <span class="badge badge-danger" title="Cancelled">2</span>
                            <span class="sidenav-icon icon icon-folder-open-o"></span>
                            <span class="sidenav-label">Applicants</span>
                        </a>
                    </li>
                </ul-->
            </nav>
        </div>
    </div>
</div>