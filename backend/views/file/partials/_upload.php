<?php
/**
 * Date: 25.07.2017
 * Time: 11:52
 */

use sn\fileupload\FileUploadUI;

echo FileUploadUI::widget([
    'model' => $model,
    'gallery' => false,
    'attribute' => 'file',
    'url' => $action,
    'fieldOptions' => [
        'multiple' => true
    ],
    'clientOptions' => [
        'maxFileSize' => 50000000,
        'limitMultiFileUploads' => 10,
        'uploadedContainer' => '#files-grid table tbody',
        'prependFiles' => true,
    ],
    'options' => ['class' => 'inner-offset-vertical inner-offset-horizontal form-upload'],
    'formView' => '/file/upload/form',
    'downloadTemplateView' => '/file/upload/download',
    'uploadTemplateView' => '/file/upload/upload',
    'clientEvents' => [
        'fileuploaddone' => ' function(e, data) {
            if(data.files.length){
                $(".fileupload-buttonbar .start, .fileupload-buttonbar .cancel").removeClass("hidden");
            }
        }',
        'fileuploadalways' => 'function(e, data) {
            var fileList =  ($(this).data("blueimp-fileupload") || $(this).data("fileupload"));
            if(!fileList.options.filesContainer.find(".start, .cancel").length){
                $(".fileupload-buttonbar .start, .fileupload-buttonbar .cancel").addClass("hidden");
            }        
        }',
        'fileuploadadd' => ' function(e, data) {
            if(data.files.length){
                $(".fileupload-buttonbar .start, .fileupload-buttonbar .cancel").removeClass("hidden");
            }
        }'
    ],
    'fileuploadEvents' => [
//        'stopped' => "function(e){
//            var container = $(this).parents('.panel'),
//                sform = $(container).find('form#form_search');
//            $(sform).trigger('submit');
//        }",
        'finished' => 'function(e, data) {
            var fileList =  ($(this).data("blueimp-fileupload") || $(this).data("fileupload"));
            if(!fileList.options.filesContainer.find(".start, .cancel").length){
                $(".fileupload-buttonbar .start, .fileupload-buttonbar .cancel").addClass("hidden");
            }        
        }',
    ],
]);
