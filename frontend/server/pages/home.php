<div class="row">
    <div class="col-md-3">
        <p class="lead">Data Panel</p>
        <div class="list-group">
            <a href="#" class="list-group-item active">Stromzähler 1</a>
            <a href="#" class="list-group-item">Stromzähler 1</a>
            <a href="#" class="list-group-item">Gaszähler</a>
        </div>
    </div>

    <div class="col-md-9">
        <div class="row">
            <div class="col-lg-12">
                <div id="current_data"></div>
            </div
            <div class="col-lg-12">
                <div id="energy_data"></div>
                <div class="pull-right">
                    <p id="sum-data">SUM: 150kWh</p>
                </div>
                <div class="btn-group btn-group-justified">
                    <a id="daily" href="#" class="btn btn-primary">Tag</a>
                    <a id="weekly" href="#" class="btn btn-primary">Woche</a>
                    <a id="monthly" href="#" class="btn btn-primary">Monat</a>
                    <a id="yearly" href="#" class="btn btn-primary">Jahr</a>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript" src="js/meter1.js"></script>