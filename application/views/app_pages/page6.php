<div class="container-ems" style="height: 100%;">
    <div class="row">
        <div class="col-lg-4">
            <div class="card card-primary">
                <div class="card-body">
                    <h4 class="text-bold text-center">RASIO DAYA PENERANGAN</h4>
                    <div id="chart1" style="height: 800px;"></div>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card card-primary">
                <div class="card-body">
                    <h4 class="text-bold text-center">RASIO DAYA ELEKTRONIK</h4>
                    <div id="chart2" style="height: 800px;"></div>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card card-primary">
                <div class="card-body">
                    <h4 class="text-bold text-center">RASIO DAYA LIFT</h4>
                    <div id="chart3" style="height: 800px;"></div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="<?= base_url('assets-' . app_version() . '/') ?>plugins/jquery/jquery.min.js"></script>
<script src="<?= base_url('assets-' . app_version() . '/') ?>plugins/echarts/echarts.min.js"></script>
<script src="<?= base_url('assets-' . app_version() . '/') ?>dist/js/page6.js" type="module"></script>