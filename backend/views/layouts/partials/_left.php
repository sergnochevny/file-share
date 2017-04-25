<?php

use common\widgets\Menu;
use common\helpers\Url;
use backend\models\Company;
use backend\models\Investigation;
use backend\models\User;
use yii\helpers\Html;


/** @var Company|null $userCompany */
$userCompany = Yii::$app->user->identity->company;
?>
<div class="layout-sidebar">
    <div class="layout-sidebar-backdrop"></div>
    <div class="layout-sidebar-body">
        <div class="custom-scrollbar">
            <nav id="sidenav" class="sidenav-collapse collapse">
                <?php
                $items[] = ['label' => 'Navigation', 'options' => ['class' => 'sidenav-heading']];
                $items[] = ['label' => 'Home', 'url' => Url::to(['/site'], true), 'options' => ['icon' => 'icon-home']];
                $items[] = [
                    'label' => 'Companies',
                    'url' => ['/company'],
                    'options' => ['icon' => 'icon-contao'],
                    'visible' => !User::isClient()
                ];

                $items[] = [
                    'label' => 'Applicants',
                    'url' => ['/investigation'],
                    'options' => ['icon' => 'icon-folder-open-o'],
                ];
                $items[] = [
                    'label' => 'Applicant Types',
                    'url' => ['/investigation-type'],
                    'options' => ['icon' => 'icon-info-circle'],
                    'visible' => !User::isClient(),
                ];
                $items[] = ['label' => 'History', 'url' => ['/history'], 'options' => ['icon' => 'icon-history']];
                $items[] = ['label' => 'Forms & templates', 'url' => ['/file'], 'options' => ['icon' => 'icon-save']];
                $items[] = [
                    'label' => 'Users',
                    'url' => ['/user'],
                    'options' => ['icon' => 'icon-users'],
                    'visible' => !User::isClient(),
                ];
                $items[] = [
                    'label' => 'Settings',
                    'url' => ['/site/settings'],
                    'options' => ['icon' => 'icon-cogs'],
                    'visible' => User::isSuperAdmin()
                ];
                ?>
                <?= Menu::widget([
                    'options' => ['class' => 'sidenav'],
                    'itemOptions' => ['class' => 'sidenav-item'],
                    'linkTemplate' => '<a href="{url}"><span class="sidenav-icon icon {icon}"></span><span class="sidenav-label">{label}</span></a>',
                    'activeItem' => function ($widget, $item) {
                        $res = null;
                        if (isset($item['url']) && isset($item['url'][0])) {
                            $route = is_array($item['url']) ? $item['url'][0] : $item['url'];
                            if ((ltrim($route, '/') == 'investigation') &&
                                (Yii::$app->controller->id == 'file') &&
                                (Yii::$app->controller->action->id == 'index') &&
                                (!empty(Yii::$app->controller->actionParams['id']))) $res = true;
                            if ((ltrim($route, '/') == 'file') &&
                                (Yii::$app->controller->id == 'file') &&
                                (Yii::$app->controller->action->id == 'index') &&
                                (!empty(Yii::$app->controller->actionParams['id']))) $res = false;
                        }
                        return $res;
                    },
                    'items' => $items
                ]); ?>
            </nav>
        </div>
    </div>
</div>