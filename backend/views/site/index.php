<div class="title-bar">
    <div class="title-bar-actions">
        <select class="selectpicker dropdown" name="period" data-dropdown-align-right="true" data-style="btn-default btn-sm" data-width="fit">
            <option value="today">Today</option>
            <option value="yesterday">Yesterday</option>
            <option value="last_7d" selected="selected">Last 7 days</option>
            <option value="last_1m">Last 30 days</option>
            <option value="last_3m">Last 90 days</option>
        </select>
    </div>
    <h1 class="title-bar-title">
        <span class="d-ib"><span class="icon icon-home"></span> Home</span>
    </h1>
    <p class="title-bar-description">
        <small>Extended statistics for all projects</small>
    </p>
</div>


<div class="row gutter-xs">
    <div class="col-md-4">
        <div class="card">
            <div class="card-body">
                <div class="media">
                    <div class="media-middle media-left">
                      <span class="bg-gray sq-64 circle">
                        <span class="icon icon-flag"></span>
                      </span>
                    </div>
                    <div class="media-middle media-body">
                        <h3 class="media-heading">
                            <span class="fw-l">1,256 Issues</span>
                            <span class="fw-b fz-sm text-danger">
                          <span class="icon icon-caret-up"></span>
                          15%
                        </span>
                        </h3>
                        <small>6 issues are unassigned</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card">
            <div class="card-body">
                <div class="media">
                    <div class="media-middle media-left">
                        <div class="media-chart">
                            <canvas data-chart="doughnut" data-animation="false" data-labels='["Resolved", "Unresolved"]' data-values='[{"backgroundColor": ["#87764e", "#525252"], "borderColor": ["#292929", "#292929"], "data": [879, 377]}]' data-hide='["legend", "scalesX", "scalesY", "tooltips"]' height="64" width="64"></canvas>
                        </div>
                    </div>
                    <div class="media-middle media-body">
                        <h2 class="media-heading">
                            <span class="fw-l">879</span>
                            <small>Resolved</small>
                        </h2>
                        <small>More than 70% resolved issues</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card">
            <div class="card-body">
                <div class="media">
                    <div class="media-middle media-left">
                        <div class="media-chart">
                            <canvas data-chart="doughnut" data-animation="false" data-labels='["Resolved", "Unresolved"]' data-values='[{"backgroundColor": ["#525252", "#87764e"], "borderColor": ["#292929", "#292929"], "data": [879, 377]}]' data-hide='["legend", "scalesX", "scalesY", "tooltips"]' height="64" width="64"></canvas>
                        </div>
                    </div>
                    <div class="media-middle media-body">
                        <h2 class="media-heading">
                            <span class="fw-l">377</span>
                            <small>Unresolved</small>
                        </h2>
                        <small>Less than 30% unresolved issues</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



<div class="row gutter-xs">
    <div class="col-xs-12 col-md-6">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Income / Expenses</h4>
            </div>
            <div class="card-body">
                <div class="card-chart">
                    <canvas data-chart="line" data-animation="false" data-labels='["Sun", "Mon", "Tue", "Wed", "Thu", "Fri", "Sat"]' data-values='[{"label": "Income", "backgroundColor": "transparent", "borderColor": "#87764e", "pointBackgroundColor": "#87764e", "data": [29432, 20314, 17665, 22162, 31194, 35053, 29298]}, {"label": "Expenses", "backgroundColor": "transparent", "borderColor": "#da1021", "pointBackgroundColor": "#da1021", "data": [9956, 22607, 30963, 22668, 16338, 22222, 39238]}]' data-tooltips='{"mode": "label"}' data-hide='["gridLinesX", "legend"]' height="150"></canvas>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xs-12 col-md-6">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Pass / Failed</h4>
            </div>
            <div class="card-body">
                <div class="card-chart">
                    <canvas data-chart="bar" data-animation="false" data-labels='["Sun", "Mon", "Tue", "Wed", "Thu", "Fri", "Sat"]' data-values='[{"label": "Pass", "backgroundColor": "#87764e", "borderColor": "#87764e", "data": [3089, 2132, 1854, 2326, 3274, 3679, 3075]}, {"label": "Failed", "backgroundColor": "#da1021", "borderColor": "#da1021", "data": [983, 2232, 3057, 2238, 1613, 2194, 3874]}]' data-tooltips='{"mode": "label"}' data-hide='["gridLinesX", "legend"]' height="150"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>
