<div class="container-ems" style="height: 100%;">
    <div class="row">
        <div class="col-lg-6">
            <div class="card card-primary" style="height: 100%;">
                <div class="card-body">
                    <h4 class="text-bold text-center">BEBAN TOTAL HARI INI</h4>
                    <div id="chart1" style="height: 850px;"></div>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="row">
                <div class="col-lg-6">
                    <div class="card card-primary" style="height: 100%;">
                        <div class="card-body">
                            <h4 class="text-bold text-center">ARUS</h4>
                            <div id="chart2" style="height: 360px;"></div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="card card-primary" style="height: 100%;">
                        <div class="card-body">
                            <h4 class="text-bold text-center">TEGANGAN</h4>
                            <div id="chart3" style="height: 360px;"></div>
                        </div>
                    </div>
                </div>
            </div>
            <br>
            <div class="card card-primary"">
                <div class="card-body">
                    <h4 class="text-bold text-center">POWER FACTOR</h4>
                    <div id="chart4" style="height: 370px;"></div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="<?= base_url('assets-' . app_version() . '/') ?>plugins/jquery/jquery.min.js"></script>
<script src="<?= base_url('assets-' . app_version() . '/') ?>plugins/echarts/echarts.min.js"></script>
<script src="<?= base_url('assets-' . app_version() . '/') ?>dist/js/page3.js" type="module"></script>