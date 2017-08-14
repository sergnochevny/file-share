<?php

use common\widgets\Menu;
use common\helpers\Url;
use backend\models\Company;
use backend\models\Investigation;
use backend\models\User;
use yii\helpers\Html;


/** @var Company|null $userCompany */
$user = Yii::$app->user->identity;
$userCompany = !empty($user) ? $user->company : null;
?>
<div class="layout-sidebar">
    <div class="layout-sidebar-backdrop"></div>
    <div class="layout-sidebar-body">
        <div class="custom-scrollbar">
            <nav id="sidenav" class="sidenav-collapse collapse">
                <?php
                $items[] = ['label' => 'Navigation', 'options' => ['class' => 'sidenav-heading']];
                $items[] = [
                    'label' => 'Home',
                    'url' => Url::to(['/site/index'], true),
                    'options' => ['icon' => 'icon-home'],
                    'visible' => Yii::$app->user->can('company.index'),
                ];
                $items[] = [
                    'label' => 'Companies',
                    'url' => ['/company/index'],
                    'options' => ['icon' => 'icon-contao'],
                    'visible' => Yii::$app->user->can('company.index'),
                ];

                $items[] = [
                    'label' => 'Applicants',
                    'url' => ['/investigation/index'],
                    'options' => ['icon' => 'icon-folder-open-o'],
                    'visible' => Yii::$app->user->can('investigation.index'),
                ];
                $items[] = [
                    'label' => 'Investigative services',
                    'url' => ['/investigation-type/index'],
                    'options' => ['icon' => 'icon-info-circle'],
                    'visible' => Yii::$app->user->can('investigation-type.index'),
                ];
                $items[] = [
                    'label' => 'History',
                    'url' => ['/history'],
                    'options' => ['icon' => 'icon-history'],
                ];
                $items[] = [
                        'label' => 'Forms & templates',
                    'url' => ['/file/index'],
                    'options' => ['icon' => 'icon-save'],
                    'visible' => Yii::$app->user->can('file.index'),
                ];
                $items[] = [
                    'label' => 'Users',
                    'url' => ['/user/index'],
                    'options' => ['icon' => 'icon-users'],
                    'visible' => \Yii::$app->user->can('user.index'),
                ];
                $items[] = [
                    'label' => 'Settings',
                    'url' => ['/site/settings'],
                    'options' => ['icon' => 'icon-cogs'],
                    'visible' => \Yii::$app->user->can('site.settings'),
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
                            if (((ltrim($route, '/') == 'investigation') || (ltrim($route,
                                            '/') == 'investigation/index')) &&
                                (Yii::$app->controller->id == 'file') &&
                                (Yii::$app->controller->action->id == 'index') &&
                                (!empty(Yii::$app->controller->actionParams['id']))) {
                                $res = true;
                            }
                            if (((ltrim($route, '/') == 'file') || (ltrim($route, '/') == 'file/index')) &&
                                (Yii::$app->controller->id == 'file') &&
                                (Yii::$app->controller->action->id == 'index') &&
                                (!empty(Yii::$app->controller->actionParams['id']))) {
                                $res = false;
                            }
                        }
                        return $res;
                    },
                    'items' => $items
                ]); ?>
            </nav>
        </div>
    </div>
</div>