<?php
/** @var $this \yii\web\View */
?>

<div id="tab-1" class="tab-pane active">
    <?= $this->render('_select-company') ?>
    <div class="clearfix"></div>
    <hr/>
    <div class="row">
        <div class="col-sm-6">
            <div class="form-group">
                <label class="col-sm-4 control-label" for="form-control-1">Company Name</label>

                <div class="col-sm-8">
                    <input id="form-control-1" class="form-control" type="text">
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-4 control-label" for="form-control-1">City</label>

                <div class="col-sm-8">
                    <input id="form-control-1" class="form-control" type="text">
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-4 control-label" for="form-control-1">zip</label>

                <div class="col-sm-8">
                    <input id="form-control-1" class="form-control" type="text">
                </div>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="form-group">
                <label class="col-sm-4 control-label" for="form-control-1">Company Address</label>

                <div class="col-sm-8">
                    <input id="form-control-1" class="form-control" type="text">
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-4 control-label" for="form-control-1">State</label>

                <div class="col-sm-8">
                    <input id="form-control-1" class="form-control" type="text">
                </div>
            </div>
        </div>
        <div class="clearfix"></div>
        <hr/>
        <div align="center">
            <button class="btn btn-sm btn-labeled  arrow-warning" type="button">
                                                        <span class="btn-label">
                                                            <span
                                                                class="icon icon-check-square   icon-lg icon-fw"></span>
                                                        </span>
                Create
            </button>
            <button class="btn btn-sm btn-labeled  arrow-success" type="button">
                                                        <span class="btn-label">
                                                            <span
                                                                class="icon icon-chevron-circle-right  icon-lg icon-fw"></span>
                                                        </span>
                Next
            </button>
        </div>
    </div>
</div>