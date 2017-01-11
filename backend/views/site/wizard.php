<div class="panel panel-default">
<div class="panel-body panel-collapse">
    <div align="center">
        <h1>
            <span class="d-ib"><span class="icon icon-magic"></span> Wizard form</span>
        </h1>

        <p>
            <small>Add and edit Company, Agents and Investigations</small>
        </p>
    </div>


    <div class="demo-form-wrapper">
        <form id="demo-form-wizard-1" novalidate="" class="form form-horizontal">
            <hr/>
            <ul class="steps">
                <li class="step col-xs-4 active">
                    <a class="step-segment" href="#tab-1" data-toggle="tab" aria-expanded="true">
                        <span class="step-icon icon icon-contao"></span>
                    </a>

                    <div class="step-content">
                        <strong class="hidden-xs">Company</strong>
                    </div>
                </li>
                <li class="step col-xs-4">
                    <a class="step-segment" href="#tab-2" data-toggle="tab" aria-expanded="false">
                        <span class="step-icon icon icon-users"></span>
                    </a>

                    <div class="step-content">
                        <strong class="hidden-xs">Users</strong>
                    </div>
                </li>
                <li class="step col-xs-4">
                    <a class="step-segment" href="#tab-3" data-toggle="tab" aria-expanded="false">
                        <span class="step-icon icon icon-folder-open-o"></span>
                    </a>

                    <div class="step-content">
                        <strong class="hidden-xs">Investigations</strong>
                    </div>
                </li>
            </ul>
            <hr/>
            <div class="tab-content">
                <div id="tab-1" class="tab-pane active">
                    <div class="col-lg-6 col-lg-offset-3">
                        <h2 align="center">
                            <span class="d-ib">Select Company</span>
                        </h2>

                        <div class="form-group">
                            <select id="demo-select2-1-2" class="form-control">
                                <option value=""> - - -</option>
                                <option value="">Stark Industries</option>
                                <option value="">Stark Industries2</option>
                                <option value="">Stark Industries</option>
                                <option value="">Stark Industries2</option>
                                <option value="">Stark Industries</option>
                                <option value="">Stark Industries2</option>
                                <option value="">Stark Industries</option>
                                <option value="">Stark Industries2</option>
                                <option value="">Stark Industries</option>
                                <option value="">Stark Industries2</option>
                                <option value="">Stark Industries</option>
                                <option value="">Stark Industries2</option>
                                <option value="">Stark Industries</option>
                                <option value="">Stark Industries2</option>
                                <option value="">Stark Industries</option>
                                <option value="">Stark Industries2</option>
                                <option value="">Stark Industries</option>
                                <option value="">Stark Industries2</option>
                                <option value="">Stark Industries</option>
                                <option value="">Stark Industries2</option>

                            </select>
                            <span class="help-block">For convenience, use the quick search</span>
                        </div>
                        <!--<h5 align="center">
                            <span class="d-ib">- OR -</span>
                        </h5>
                        <p align="center">
                            <a class="btn btn-sm btn-labeled arrow-success">
                              <span class="btn-label">
                                <span class="icon icon-plus icon-lg icon-fw"></span>
                              </span>
                                Create a new Company
                            </a>
                        </p>-->
                    </div>
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
                <div id="tab-2" class="tab-pane">
                    <div class="col-lg-6 col-lg-offset-3">
                        <h2 align="center">
                            <span class="d-ib">Select Users</span>
                        </h2>

                        <div class="form-group">
                            <select id="demo-select2-1" class="form-control" multiple="multiple">
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
                        <!--<h5 align="center">
                            <span class="d-ib">- OR -</span>
                        </h5>
                        <p align="center">
                            <a class="btn btn-sm btn-labeled arrow-success">
                              <span class="btn-label">
                                <span class="icon icon-plus icon-lg icon-fw"></span>
                              </span>
                                Create a new User
                            </a>
                        </p>-->
                    </div>
                    <div class="clearfix"></div>
                    <hr/>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="col-sm-4 control-label" for="form-control-1">First Name</label>

                                <div class="col-sm-8">
                                    <input id="form-control-1" class="form-control" type="text">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4 control-label" for="form-control-1">Phone number</label>

                                <div class="col-sm-8">
                                    <input id="form-control-1" class="form-control" type="text">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4 control-label" for="form-control-1">Password</label>

                                <div class="col-sm-8">
                                    <input id="form-control-1" class="form-control" type="text">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4 control-label" for="form-control-1">Password2</label>

                                <div class="col-sm-8">
                                    <input id="form-control-1" class="form-control" type="text">
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="col-sm-4 control-label" for="form-control-1">Last Name</label>

                                <div class="col-sm-8">
                                    <input id="form-control-1" class="form-control" type="text">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4 control-label" for="form-control-1">Email</label>

                                <div class="col-sm-8">
                                    <input id="form-control-9" class="form-control" type="text"
                                           data-inputmask="'alias': 'email'">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4 control-label" for="form-control-1">Status</label>

                                <div class="col-sm-8">
                                    <select id="form-control-6" class="form-control">
                                        <option value="">Contact person</option>
                                        <option value="">Agent</option>
                                        <option value="">Client</option>
                                    </select>
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
                <div id="tab-3" class="tab-pane">
                    <div class="col-lg-6 col-lg-offset-3">
                        <h2 align="center">
                            <span class="d-ib">Create Investigation</span>
                        </h2>
                        <hr/>
                        <h5 align="center">
                            <span class="d-ib">Select Company</span>
                        </h5>

                        <div class="form-group">
                            <select id="demo-select2-1-3" class="form-control">
                                <option value=""> - - -</option>
                                <option value="">Stark Industries</option>
                                <option value="">Stark Industries2</option>
                                <option value="">Stark Industries</option>
                                <option value="">Stark Industries2</option>
                                <option value="">Stark Industries</option>
                                <option value="">Stark Industries2</option>
                                <option value="">Stark Industries</option>
                                <option value="">Stark Industries2</option>
                                <option value="">Stark Industries</option>
                                <option value="">Stark Industries2</option>
                                <option value="">Stark Industries</option>
                                <option value="">Stark Industries2</option>
                                <option value="">Stark Industries</option>
                                <option value="">Stark Industries2</option>
                                <option value="">Stark Industries</option>
                                <option value="">Stark Industries2</option>
                                <option value="">Stark Industries</option>
                                <option value="">Stark Industries2</option>
                                <option value="">Stark Industries</option>
                                <option value="">Stark Industries2</option>

                            </select>
                            <span class="help-block">For convenience, use the quick search</span>
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
        </form>
    </div>


</div>
</div>