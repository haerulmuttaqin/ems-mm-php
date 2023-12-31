<div class="container-ems" style="height: 100%;">
    <div class="row">
        <div class="col-lg-6">
            <div class="card card-primary">
                <div class="card-body">
                    <h4 class="text-bold text-center">TABEL PENGUKURAN ENERGY</h4>
                    <table class="table" style="height: 100%;">
                        <thead class="thead-dark">
                        <tr>
                            <th scope="col">DEVICE</th>
                            <th scope="col">ACTIVE ENERGY IMPORT</th>
                            <th scope="col">REACTIVE ENERGY IMPORT</th>
                        </tr>
                        </thead>
                         <tbody>
                            <?php foreach ($data as $item) : ?>
                            <tr>
                                <th><?= $item['caption'] ?></th>
                                <td><?= $item['value_active_e'] ?: 0 ?></td>
                                <td><?= $item['value_reactive_e'] ?: 0 ?></td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>

                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="card card-primary">
                <div class="card-body">
                    <h4 class="text-bold text-center">RASIO DAYA PENERANGAN PER LANTAI</h4>
                    <div id="chart1" style="height: 370px;"></div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-6">
                    <div class="card card-primary" style="height: 100%;">
                        <div class="card-body">
                            <h4 class="text-bold text-center">ELEKTRONIK</h4>
                            <div id="chart2" style="height: 360px;"></div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="card card-primary" style="height: 100%;">
                        <div class="card-body">
                            <h4 class="text-bold text-center">LIFT</h4>
                            <div id="chart3" style="height: 360px;"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="<?= base_url('assets-' . app_version() . '/') ?>plugins/jquery/jquery.min.js"></script>
<script src="<?= base_url('assets-' . app_version() . '/') ?>plugins/echarts/echarts.min.js"></script>
<script src="<?= base_url('assets-' . app_version() . '/') ?>dist/js/page5.js" type="module"></script>