<?php
use yii\helpers\Html;
use common\helpers\Url;

?>
<div class="layout-header">
    <div class="navbar navbar-default">
        <div class="navbar-header">
            <?=
            Html::a(
                Html::img(
                    Url::to(['/images/logo.png'], true), [
                        'alt' => 'Plan. Protect. Prosper.',
                        'class' => 'navbar-brand-logo'
                    ]
                ), Url::to(['/'], true), [
                    'class' => 'navbar-brand navbar-brand-center'
                ]
            )
            ?>
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
                <?= Html::img(Url::to('@web/images/admin-foto.jpg', true), ['class' => 'ellipsis-object', 'width' => '32', 'height' => '32']) ?>
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
                        <h4 class="navbar-text text-center">Hi, Admin</h4>
                    </li>
                    <!--li class="hidden-xs hidden-sm">
                        <?= Html::beginForm('', 'post', ['class' => 'navbar-search navbar-search-collapsed']); ?>
                            <?= Html::input('string', 'global-search', null, [
                        'class' => 'navbar-search-input',
                        'placeholder' => 'Search for people, companies'
                    ]); ?>
                            <?= Html::button(
                        Html::tag('span', '', ['class' => 'icon icon-search icon-lg']), [
                            'class' => 'navbar-search-toggler', 'title' => 'Expand search form ( S )', 'aria-expanded' => 'false'
                        ]
                    ); ?>
                        <?= Html::endForm(); ?>
                    </li-->
                    <li class="dropdown hidden">
                        <a class="dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true"
                           style="height: 45px">
                          <span class="icon-with-child hidden-xs">
                            <span class="icon icon-bell-o icon-lg"></span>
                            <span class="badge badge-danger badge-above right">3</span>
                          </span>
                            <span class="visible-xs-block">
                            <span class="icon icon-bell icon-lg icon-fw"></span>
                            <span class="badge badge-danger pull-right">3</span>
                            Notifications
                          </span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right dropdown-menu-lg">
                            <div class="dropdown-header">
                                <a class="dropdown-link" href="#">Mark all as read</a>
                                <h5 class="dropdown-heading">Recent Notifications</h5>
                            </div>
                            <div class="dropdown-body">
                                <div class="list-group list-group-divided custom-scrollbar">
                                    <a class="list-group-item" href="#">
                                        <div class="notification">
                                            <div class="notification-media">
                                                <span class="icon icon-exclamation-triangle bg-warning rounded sq-40"></span>
                                            </div>
                                            <div class="notification-content">
                                                <small class="notification-timestamp">35 min</small>
                                                <h5 class="notification-heading">Moving to archive</h5>
                                                <p class="notification-text">
                                                    <small class="truncate">Project <b>Ethan Walker</b> moved to the
                                                        archive
                                                    </small>
                                                </p>
                                            </div>
                                        </div>
                                    </a>
                                    <a class="list-group-item" href="#">
                                        <div class="notification">
                                            <div class="notification-media">
                                                <span class="icon icon-flag bg-success rounded sq-40"></span>
                                            </div>
                                            <div class="notification-content">
                                                <small class="notification-timestamp">43 min</small>
                                                <h5 class="notification-heading">Added new user</h5>
                                                <p class="notification-text">
                                                    <small class="truncate">Added new user: <b>Charlotte Harrison</b>
                                                    </small>
                                                </p>
                                            </div>
                                        </div>
                                    </a>
                                    <a class="list-group-item" href="#">
                                        <div class="notification">
                                            <div class="notification-media">
                                                <span class="icon icon-exclamation-triangle bg-warning rounded sq-40"></span>
                                            </div>
                                            <div class="notification-content">
                                                <small class="notification-timestamp">1 hr</small>
                                                <h5 class="notification-heading">Moving to archive</h5>
                                                <p class="notification-text">
                                                    <small class="truncate">Project <b>Sophia Evans</b> moved to the
                                                        archive
                                                    </small>
                                                </p>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            </div>
                            <div class="dropdown-footer">
                                <a class="dropdown-btn" href="#">See All</a>
                            </div>
                        </div>
                    </li>
                    <li class="dropdown hidden-xs">
                        <button class="navbar-account-btn" data-toggle="dropdown" aria-haspopup="true">
                            <i class="icon icon-user" style="margin-top: 8px; font-size: 1.5em"></i>
                            <?= !is_null(Yii::$app->user->identity->username) ? ucfirst(Yii::$app->user->identity->username) : null; ?>
                            <span class="caret"></span>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-right">
                            <li>
                                <a href="#">
                                    <h5 class="navbar-upgrade-heading">
                                        <?= !is_null(Yii::$app->user->identity->username) ? ucfirst(Yii::$app->user->identity->username) : null; ?>
                                        <small class="navbar-upgrade-notification">
                                            Last Active
                                            <?= !empty(Yii::$app->user->identity) ? Yii::$app->formatter->asDatetime(Yii::$app->user->identity->action_at) : '' ?>
                                        </small>
                                    </h5>
                                </a>
                            </li>
                            <li class="divider"></li>
                            <!--                            <li><a href="#">Contacts</a></li>-->
                            <!--                            <li><a href="-->
                            <?= ''//Url::to(['/profile', 'username' => isset(Yii::$app->user->identity->id) ? Yii::$app->user->identity->username : null], true)    ?><!--">Profile</a></li>-->
                            <li><a href="<?= Url::to(['/site/logout'], true) ?>" data-method="POST">Sign out</a></li>
                        </ul>
                    </li>
                    <li class="visible-xs-block">
                        <a href="#">
                            <span class="icon icon-users icon-lg icon-fw"></span>
                            Contacts
                        </a>
                    </li>
                    <li class="visible-xs-block">
                        <a href="#">
                            <span class="icon icon-user icon-lg icon-fw"></span>
                            Profile
                        </a>
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