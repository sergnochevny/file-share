<?php

use ait\utilities\helpers\Url;
use backend\models\User;

/** @var \common\models\User $user */
$user = Yii::$app->user->identity;

$icon = 'c.png';
if (User::isSuperAdmin()) {
    $icon = 's.png';
} elseif (User::isAdmin()) {
    $icon = 'a.png';
}
$userIconSrc = Url::to(['/images/users/photo/' . $icon], true);
?>
<div class="layout-header">
    <div class="navbar navbar-default">
        <div class="navbar-header">
            <a class="navbar-brand navbar-brand-center" href="<?= Url::to(['/'], true) ?>">
                <img class="navbar-brand-logo" src="<?= Url::to(['/images/logo.png'], true) ?>"
                     alt="Plan. Protect. Prosper.">
            </a>
            <button class="navbar-toggler visible-xs-block collapsed" type="button" data-toggle="collapse"
                    data-target="#sidenav">
                <span class="sr-only">Toggle navigation</span>
                <span class="bars">
              <span class="bar-line bar-line-1 out"></span>
              <span class="bar-line bar-line-2 out"></span>
              <span class="bar-line bar-line-3 out"></span>
            </span>
                <span class="bars bars-x">
              <span class="bar-line bar-line-4"></span>
              <span class="bar-line bar-line-5"></span>
            </span>
            </button>
            <button class="navbar-toggler visible-xs-block collapsed" type="button" data-toggle="collapse"
                    data-target="#navbar">
                <span class="sr-only">Toggle navigation</span>
                <span class="arrow-up"></span>
                <span class="ellipsis ellipsis-vertical">
                   <!-- <i class="ellipsis-object icon icon-user" style="font-size: 1.5em"></i>-->
                    <img class="ellipsis-object" src="<?= $userIconSrc ?>" width="32" height="32" alt="">
                </span>
            </button>
        </div>
        <div class="navbar-toggleable">
            <nav id="navbar" class="navbar-collapse collapse">
                <button class="sidenav-toggler hidden-xs" title="Collapse sidenav ( [ )" aria-expanded="true"
                        type="button">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="bars">
                        <span class="bar-line bar-line-1 out"></span>
                        <span class="bar-line bar-line-2 out"></span>
                        <span class="bar-line bar-line-3 out"></span>
                        <span class="bar-line bar-line-4 in"></span>
                        <span class="bar-line bar-line-5 in"></span>
                        <span class="bar-line bar-line-6 in"></span>
                    </span>
                </button>
                <ul class="nav navbar-nav navbar-right">
                    <li class="visible-xs-block">
                        <h4 class="navbar-text text-center">
                            Hi, <?= !empty($user) ? ucfirst($user->username) : ''; ?></h4>
                    </li>

                    <li class="dropdown hidden-xs">
                        <button class="navbar-account-btn" data-toggle="dropdown" aria-haspopup="true">
                            <img src="<?= $userIconSrc ?>" width="32" height="32" alt="">
                            <!--<i class="icon icon-user" style="margin-top: 8px; font-size: 1.5em"></i>-->
                            <?= !empty($user) ? ucfirst($user->username) : ''; ?>
                            <span class="caret"></span>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-right">
                            <li>
                                <a href="#">
                                    <h5 class="navbar-upgrade-heading">
                                        <?= !empty($user) ? ucfirst($user->username) : ''; ?>
                                        <small class="navbar-upgrade-notification">
                                            Last Active
                                            <?= !empty($user) ? Yii::$app->formatter->asDatetime($user->action_at) : ''; ?>
                                            UTC
                                        </small>
                                    </h5>
                                </a>
                            </li>
                            <li class="divider"></li>
                            <li><a href="<?= Url::to(['/site/logout'], true) ?>" data-method="POST">Sign out</a></li>
                        </ul>
                    </li>
                    <li class="visible-xs-block">
                        <a href="<?= Url::to(['/site/logout'], true) ?>" data-method="POST">
                            <span class="icon icon-power-off icon-lg icon-fw"></span>
                            Sign out
                        </a>
                    </li>
                </ul>
            </nav>
        </div>
    </div>
</div>