<?php
/** @var \ait\fileupload\FileUploadUI $this */
use yii\helpers\Html;

$context = $this->context;
?>
    <!-- The file upload form used as target for the file upload widget -->
<?= Html::beginTag('div', $context->options); ?>
    <!-- The fileupload-buttonbar contains buttons to add/delete files and start/cancel the upload -->
    <div class="row fileupload-buttonbar">
        <div class="col-xs-12">
            <!-- The fileinput-button span is used to style the file input field as button -->
            <span class="btn btn-success fileinput-button">
                <i class="glyphicon glyphicon-plus"></i>
                <span>Add files...</span>

                <?= $context->model instanceof \yii\base\Model && $context->attribute !== null
                    ? Html::activeFileInput($context->model, $context->attribute, $context->fieldOptions)
                    : Html::fileInput($context->name, $context->value, $context->fieldOptions);?>

            </span>
            <a class="btn btn-primary start hidden">
                <i class="glyphicon glyphicon-upload"></i>
                <span><?= Yii::t('fileupload', 'Start upload') ?></span>
            </a>
            <a class="btn btn-warning cancel hidden">
                <i class="glyphicon glyphicon-ban-circle"></i>
                <span><?= Yii::t('fileupload', 'Cancel upload') ?></span>
            </a>
            <!-- The global file processing state -->
            <span class="fileupload-process"></span>
        </div>
        <!-- The global progress state -->
        <div class="col-xs-12 fileupload-progress fade">
            <!-- The global progress bar -->
            <div class="progress progress-striped progress-xs active" role="progressbar" aria-valuemin="0" aria-valuemax="100">
                <div class="progress-bar progress-bar-indicating progress-bar-warning" style="width:0%;"></div>
            </div>
            <!-- The extended global progress state -->
            <div class="progress-extended">&nbsp;</div>
        </div>
    </div>
    <!-- The table listing the files available for upload/download -->
    <table role="presentation" class="table table-striped"><tbody class="files"></tbody></table>
<?= Html::endTag('div');?>
