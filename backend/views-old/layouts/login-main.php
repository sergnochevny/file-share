<?php
/** @var $this \yii\web\View */

\backend\assets\LoginAsset::register($this);
?>

<?php $this->beginContent('@backend/views/layouts/base.php'); ?>


    <div class="login">
        <div class="login-body">
            <a class="login-brand" href="index.php">
                <img class="img-responsive" src="images/logo.png" alt="Plan. Protect. Prosper.">
            </a>
            
            <?= $content ?>

        </div>
        <div class="login-footer">
            <ul class="list-inline">
                <li><a  href="#">Sign up</a></li>
                <li>|</li>
                <li><a  href="#">Privacy Policy</a></li>
                <li>|</li>
                <li><a  href="#">Terms</a></li>
                <li>|</li>
                <li><a  href="#">Cookie Policy</a></li>
                <li>|</li>
                <li>© Protus3 <?= date('Y') ?></li>
            </ul>
        </div>
    </div>

<?php $this->endContent() ?>