<?php

use dmstr\widgets\Menu;

?>
<aside class="main-sidebar">
    <section class="sidebar">

        <!-- Sidebar user panel -->
<!--        <div class="user-panel">
            <div class="pull-left image">
                <img src="<?/*= $directoryAsset */?>/img/user2-160x160.jpg" class="img-circle" alt="User Image"/>
            </div>
            <div class="pull-left info">
                <p>Alexander Pierce</p>

                <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
            </div>
        </div>-->

        <!-- search form
        <form action="#" method="get" class="sidebar-form">
            <div class="input-group">
                <input type="text" name="q" class="form-control" placeholder="Search..."/>
              <span class="input-group-btn">
                <button type='submit' name='search' id='search-btn' class="btn btn-flat"><i class="fa fa-search"></i>
                </button>
              </span>
            </div>
        </form>
        <!-- /.search form -->

        <?= Menu::widget(
            [
                'options' => ['class' => 'sidenav'],
                'items' => [
                    //['label' => 'Menu Yii2', 'options' => ['class' => 'header']],
                    ['label' => 'Home', 'icon' => 'fa fa-home', 'url' => ['/site/index']],
                    ['label' => 'Wizard', 'icon' => 'fa fa-magic', 'url' => ['/wizard']],
                    ['label' => 'Companies', 'icon' => 'fa fa-contao', 'url' => ['/company/index']],
                    ['label' => 'Applicants', 'icon' => 'fa fa-folder-open-o', 'url' => ['/investigation/index']],
                    ['label' => 'History', 'icon' => 'fa fa-history', 'url' => ['/investigation/history']],
                    ['label' => 'Users', 'icon' => 'fa fa-users', 'url' => ['/user/index']],
                    ['label' => 'Files', 'icon' => 'fa fa-save', 'url' => ['/file/index']],
                    ['label' => 'Roles & Access', 'url' => '#',
                        'items' => [
                            ['label' => 'Role', 'icon' => 'fa fa-users', 'url' => ['/admin/role']],
                            ['label' => 'Route', 'icon' => 'fa fa-users', 'url' => ['/admin/route']],
                            ['label' => 'Permission', 'icon' => 'fa fa-users', 'url' => ['/admin/permission']],
                            ['label' => 'Assignment', 'icon' => 'fa fa-users', 'url' => ['/admin/assignment']],
                        ]
                    ],

                ],
                'itemOptions' => ['class' => 'sidenav-item']
            ]
        ) ?>

    </section>

</aside>
