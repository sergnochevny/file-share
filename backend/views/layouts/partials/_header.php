<?php
use yii\helpers\Html;
use yii\helpers\Url;

?>
<div class="layout-header">
    <div class="navbar navbar-default">
        <div class="navbar-header">
            <?=
            Html::a(
                Html::img(
                    Url::to(['/images/logo.png']), [
                        'alt' => 'Plan. Protect. Prosper.',
                        'class' => 'navbar-brand-logo'
                    ]
                ), Url::to('/'), [
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
              <img class="ellipsis-object" width="32" height="32" src="images/admin-foto.jpg" alt="Admin">
            </span>
            </button>
        </div>
        <div class="navbar-toggleable">
            <nav id="navbar" class="navbar-collapse collapse">
                <button class="sidenav-toggler hidden-xs" title="Collapse sidenav ( [ )" aria-expanded="true" type="button">
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
                    <li class="hidden-xs hidden-sm">
                        <form class="navbar-search navbar-search-collapsed">
                            <div class="navbar-search-group">
                                <input class="navbar-search-input" type="text"
                                       placeholder="Search for people, companies">
                                <button class="navbar-search-toggler" title="Expand search form ( S )"
                                        aria-expanded="false" type="submit">
                                    <span class="icon icon-search icon-lg"></span>
                                </button>
                            </div>
                        </form>
                    </li>
                    <li class="dropdown" style="display: none;">
                        <a class="dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true">
                          <span class="icon-with-child hidden-xs">
                            <span class="icon icon-envelope-o icon-lg"></span>
                            <span class="badge badge-danger badge-above right">6</span>
                          </span>
                            <span class="visible-xs-block">
                            <span class="icon icon-envelope icon-lg icon-fw"></span>
                            <span class="badge badge-danger pull-right">6</span>
                            Messages
                          </span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right dropdown-menu-lg">
                            <div class="dropdown-header">
                                <a class="dropdown-link" href="messenger.php">New Message</a>
                                <h5 class="dropdown-heading">Recent messages</h5>
                            </div>
                            <div class="dropdown-body">
                                <div class="list-group list-group-divided custom-scrollbar">
                                    <a class="list-group-item" href="messenger.php">
                                        <div class="notification">
                                            <div class="notification-media">
                                                <img class="rounded" width="40" height="40"
                                                     src="images/users/photo/1.jpg" alt="Harry Jones">
                                            </div>
                                            <div class="notification-content">
                                                <small class="notification-timestamp">16 min</small>
                                                <h5 class="notification-heading">Harry Jones</h5>
                                                <p class="notification-text">
                                                    <small class="truncate">Lorem Ipsum is simply dummy text of the
                                                        printing and typesetting industry.
                                                    </small>
                                                </p>
                                            </div>
                                        </div>
                                    </a>
                                    <a class="list-group-item" href="messenger.php">
                                        <div class="notification">
                                            <div class="notification-media">
                                                <img class="rounded" width="40" height="40"
                                                     src="images/users/photo/2.jpg" alt="Daniel Taylor">
                                            </div>
                                            <div class="notification-content">
                                                <small class="notification-timestamp">2 hr</small>
                                                <h5 class="notification-heading">Daniel Taylor</h5>
                                                <p class="notification-text">
                                                    <small class="truncate">Lorem Ipsum is simply dummy text of the
                                                        printing and typesetting industry.
                                                    </small>
                                                </p>
                                            </div>
                                        </div>
                                    </a>
                                    <a class="list-group-item" href="messenger.php">
                                        <div class="notification">
                                            <div class="notification-media">
                                                <img class="rounded" width="40" height="40"
                                                     src="images/users/photo/3.jpg" alt="Charlotte Harrison">
                                            </div>
                                            <div class="notification-content">
                                                <small class="notification-timestamp">Sep 20</small>
                                                <h5 class="notification-heading">Charlotte Harrison</h5>
                                                <p class="notification-text">
                                                    <small class="truncate">Lorem Ipsum is simply dummy text of the
                                                        printing and typesetting industry.
                                                    </small>
                                                </p>
                                            </div>
                                        </div>
                                    </a>
                                    <a class="list-group-item" href="messenger.php">
                                        <div class="notification">
                                            <div class="notification-media">
                                                <img class="rounded" width="40" height="40"
                                                     src="images/users/photo/1.jpg" alt="Harry Jones">
                                            </div>
                                            <div class="notification-content">
                                                <small class="notification-timestamp">16 min</small>
                                                <h5 class="notification-heading">Harry Jones</h5>
                                                <p class="notification-text">
                                                    <small class="truncate">Lorem Ipsum is simply dummy text of the
                                                        printing and typesetting industry.
                                                    </small>
                                                </p>
                                            </div>
                                        </div>
                                    </a>
                                    <a class="list-group-item" href="messenger.php">
                                        <div class="notification">
                                            <div class="notification-media">
                                                <img class="rounded" width="40" height="40"
                                                     src="images/users/photo/2.jpg" alt="Daniel Taylor">
                                            </div>
                                            <div class="notification-content">
                                                <small class="notification-timestamp">2 hr</small>
                                                <h5 class="notification-heading">Daniel Taylor</h5>
                                                <p class="notification-text">
                                                    <small class="truncate">Lorem Ipsum is simply dummy text of the
                                                        printing and typesetting industry.
                                                    </small>
                                                </p>
                                            </div>
                                        </div>
                                    </a>
                                    <a class="list-group-item" href="messenger.php">
                                        <div class="notification">
                                            <div class="notification-media">
                                                <img class="rounded" width="40" height="40"
                                                     src="images/users/photo/3.jpg" alt="Charlotte Harrison">
                                            </div>
                                            <div class="notification-content">
                                                <small class="notification-timestamp">Sep 20</small>
                                                <h5 class="notification-heading">Charlotte Harrison</h5>
                                                <p class="notification-text">
                                                    <small class="truncate">Lorem Ipsum is simply dummy text of the
                                                        printing and typesetting industry.
                                                    </small>
                                                </p>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            </div>
                            <div class="dropdown-footer">
                                <a class="dropdown-btn" href="messenger.php">See All</a>
                            </div>
                        </div>
                    </li>
                    <li class="dropdown" style="display: none">
                        <a class="dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true">
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
                            <img class="rounded" width="36" height="36" src="images/admin-foto.jpg" alt="Admin"> Admin
                            <span class="caret"></span>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-right">
                            <li>
                                <a href="#">
                                    <h5 class="navbar-upgrade-heading">
                                        Admin
                                        <small class="navbar-upgrade-notification">Last Active 12.24.2016</small>
                                    </h5>
                                </a>
                            </li>
                            <li class="divider"></li>
                            <li><a href="#">Contacts</a></li>
                            <li><a href="#">Profile</a></li>
                            <li><a href="login.php">Sign out</a></li>
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
                        <a href="#">
                            <span class="icon icon-power-off icon-lg icon-fw"></span>
                            Sign out
                        </a>
                    </li>
                </ul>
            </nav>
        </div>
    </div>
</div>