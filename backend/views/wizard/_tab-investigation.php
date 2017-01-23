<?php
/** @var $this \yii\web\View */
?>
<div id="tab-3" class="tab-pane active">
    <div class="col-lg-6 col-lg-offset-3">
        <h2 align="center">
            <span class="d-ib">Create Investigation</span>
        </h2>
        <hr/>
        <h5 align="center">
            <span class="d-ib">Select Company</span>
        </h5>

        <div class="form-group">
            <?= $this->render('_select-company') ?>
            <h5 align="center">
                <span class="d-ib">Add Agents</span>
            </h5>
            <select id="demo-select2-1-4" class="form-control" multiple="multiple">
                <option value="">Harry Potter</option>
                <option value="">Hercule Puaro</option>
                <option value="">James Bond</option>
                <option value="">Sherlock Holmes</option>
                <option value="">Harry Potter</option>
                <option value="">Hercule Puaro</option>
                <option value="">James Bond</option>
                <option value="">Sherlock Holmes</option>
                <option value="">Harry Potter</option>
                <option value="">Hercule Puaro</option>
                <option value="">James Bond</option>
                <option value="">Sherlock Holmes</option>
                <option value="">Harry Potter</option>
                <option value="">Hercule Puaro</option>
                <option value="">James Bond</option>
                <option value="">Sherlock Holmes</option>
                <option value="">Harry Potter</option>
                <option value="">Hercule Puaro</option>
                <option value="">James Bond</option>
                <option value="">Sherlock Holmes</option>
                <option value="">Harry Potter</option>
                <option value="">Hercule Puaro</option>
                <option value="">James Bond</option>
                <option value="">Sherlock Holmes</option>
                <option value="">Harry Potter</option>
                <option value="">Hercule Puaro</option>
                <option value="">James Bond</option>
                <option value="">Sherlock Holmes</option>
                <option value="">Harry Potter</option>
                <option value="">Hercule Puaro</option>
                <option value="">James Bond</option>
                <option value="">Sherlock Holmes</option>
                <option value="">Harry Potter</option>
                <option value="">Hercule Puaro</option>
                <option value="">James Bond</option>
                <option value="">Sherlock Holmes</option>
            </select>
            <span class="help-block">There is a choice of two or more people.</span>
        </div>
        <div class="clearfix"></div>
        <div clas="row">
            <div class="col-sm-12">
                <div class="form-group">
                    <label class="col-sm-3 control-label" for="form-control-1">Status</label>

                    <div class="col-sm-9">
                        <select id="form-control-6" class="form-control">
                            <option value="">In progress</option>
                            <option value="">Stopped</option>
                            <option value="">Completed</option>
                            <option value="">In history</option>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-3 control-label" for="form-control-1">Start date</label>

                    <div class="col-sm-9">
                        <div class="input-with-icon">
                            <input class="form-control" type="text" data-provide="datepicker">
                            <span class="icon icon-calendar input-icon"></span>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-3 control-label" for="form-control-1">End date</label>

                    <div class="col-sm-9">
                        <div class="input-with-icon">
                            <input class="form-control" type="text" data-provide="datepicker">
                            <span class="icon icon-calendar input-icon"></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <hr/>

        <div align="center">
            <button class="btn btn-sm btn-labeled  arrow-warning" type="button">
                                                        <span class="btn-label">
                                                            <span
                                                                class="icon icon-check-square   icon-lg icon-fw"></span>
                                                        </span>
                Create
            </button>

        </div>

    </div>
</div>