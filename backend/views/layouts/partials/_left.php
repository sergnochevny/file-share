<?php

use common\widgets\Menu;

?>
<div class="layout-sidebar">
    <div class="layout-sidebar-backdrop"></div>
    <div class="layout-sidebar-body">
        <div class="custom-scrollbar">
            <nav id="sidenav" class="sidenav-collapse collapse">
                <?= Menu::widget(
                    [
                        'options' => ['class' => 'sidenav'],
                        'itemOptions' => ['class' => 'sidenav-item'],
                        'linkTemplate' => '<a href="{url}"><span class="sidenav-icon icon {icon}"></span> <span class="sidenav-label">{label}</span></a>',
                        'items' => [
                            ['label' => 'Navigation', 'options' => ['class' => 'sidenav-heading']],
                            ['label' => 'Home', 'url' => ['/site/index'], 'options' => ['icon' => 'icon-home']],
                            ['label' => 'Companies', 'url' => ['/company/index'], 'options' => ['icon' => 'icon-contao']],
                            ['label' => 'Applicants','url' => ['/investigation/index'],'options' => ['icon' => 'icon-folder-open-o']],
                            ['label' => 'History', 'url' => ['/investigation/history'], 'options' => ['icon' => 'icon-history']],
                            ['label' => 'Files', 'url' => ['/file/index'], 'options' => ['icon' => 'icon-users']],
                            ['label' => 'Users', 'url' => ['/user/index'], 'options' => ['icon' => 'icon-save']],
                        ],
                    ]
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