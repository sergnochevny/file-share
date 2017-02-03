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
                $items = [];
                $items[] = ['label' => 'Navigation', 'options' => ['class' => 'sidenav-heading']];
                $items[] = ['label' => 'Home', 'url' => Url::to(['/site'], true), 'options' => ['icon' => 'icon-home']];
                if (Yii::$app->user->can('admin')) {
                    $items[] = [
                        'label' => 'Companies',
                        'url' => ['/company'],
                        'options' => ['icon' => 'icon-contao'],
                        'badges' => function(){
                            $count = Company::find()->count();
                            return $count ? Html::tag('span', $count, ['class' => 'badge badge-success', 'title' => 'Active']) : '';
                        }
                    ];
                }
                $items[] = [
                    'label' => 'Applicants',
                    'url' => ['/investigation'],
                    'options' => ['icon' => 'icon-folder-open-o'],
                    'badges' => function() use ($userCompany) {
                        $stPending = Investigation::STATUS_PENDING;
                        $stInProgress = Investigation::STATUS_IN_PROGRESS;

                        $q = Investigation::find()
                            ->select(['COUNT(*) as cnt', 'status', 'company_id'])
                            ->asArray()
                            ->where(['status' => [$stPending, $stInProgress]]);
                        if (isset($userCompany)) {
                            $q->andWhere(['company_id' => $userCompany->id]);
                        }
                        $counts = $q->groupBy(['status'])->all();
                        $counts = array_column($counts, 'cnt', 'status');

                        $pending = isset($counts[$stPending]) ? Html::tag('span', $counts[$stPending], ['class' => 'badge badge-info', 'title' => 'Pending']) : '';
                        $inProgress = isset($counts[$stInProgress]) ? Html::tag('span', $counts[$stInProgress], ['class' => 'badge badge-warning', 'title' => 'In progress']) : '';

                        return $pending . $inProgress;
                    },
                ];
                $items[] = ['label' => 'History', 'url' => ['/history'], 'options' => ['icon' => 'icon-history']];
                $items[] = ['label' => 'Files', 'url' => ['/file'], 'options' => ['icon' => 'icon-save']];
                //                if (Yii::$app->user->can('admin')) {
                $items[] = [
                    'label' => 'Users',
                    'url' => ['/user'],
                    'options' => ['icon' => 'icon-users'],
                    'badges' => function() use ($userCompany) {
                        $q = User::find()->joinWith('company');
                        if (isset($userCompany)) {
                            $q->andWhere(['company.id' => $userCompany->id]);
                        }
                        $count = $q->count();

                        return $count ? Html::tag('span', $count, ['class' => 'badge badge-success', 'title' => 'Active']) : '';
                    },
                ];
                //                }

                ?>
                <?= Menu::widget([
                    'options' => ['class' => 'sidenav'],
                    'itemOptions' => ['class' => 'sidenav-item'],
                    'linkTemplate' => '<a href="{url}">{badges}<span class="sidenav-icon icon {icon}"></span><span class="sidenav-label">{label}</span></a>',
                    'items' => $items
                ]) ?>
            </nav>
        </div>
    </div>
</div>