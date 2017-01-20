<div class="panel">
<div class="panel-body panel-collapse">
    <div align="center">
        <h1>
            <span class="d-ib"><span class="icon icon-magic"></span> Wizard form</span>
        </h1>

        <p>
            <small>Add and edit Company, Agents and Applicants</small>
        </p>
    </div>


    <div class="demo-form-wrapper">
        <div id="demo-form-wizard-1" class="form form-horizontal">
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
                        <strong class="hidden-xs">Applicants</strong>
                    </div>
                </li>
            </ul>
            <hr/>
            <div class="tab-content">

                <?= $this->render('_tab-company', compact('companyForm')) ?>
                <?= $this->render('_tab-user') ?>
                <?= $this->render('_tab-investigation') ?>

            </div>
        </div>
    </div>
</div>