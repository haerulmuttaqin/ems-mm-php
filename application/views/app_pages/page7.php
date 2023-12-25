<div class="container-ems" style="height: 100%;">
    <div class="row">
        <div class="col-lg-6">
            <div class="card card-primary">
                <div class="card-body">
                    <h4 class="text-bold text-center">RASIO PEMAKAIAN DAYA GEDUNG</h4>
                    <div id="chart1" style="height: 800px;"></div>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="card card-primary">
                <div class="card-body">
                    <h4 class="text-bold text-center">TABEL PENGUKURAN DAYA</h4>
                    <table class="table" style="height: 100%;">
                        <thead class="thead-dark">
                        <tr>
                            <th scope="col" style="width: 16%; vertical-align: middle;">MEASUREMENT</th>
                            <th scope="col" style="width: 16%; vertical-align: middle;">PM LIFT</th>
                            <th scope="col" style="width: 20%; vertical-align: middle;">PM PENERANGAN & STOP KONTAK</th>
                            <th scope="col" style="width: 16%; vertical-align: middle;">PM ELEKTRONIK</th>
                            <th scope="col" style="width: 16%; vertical-align: middle;">PM TATA UDARA</th>
                            <th scope="col" style="width: 16%; vertical-align: middle;">PM TATA AIR</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($data as $item) : ?>
                            <tr>
                                <th><?= $item['caption'] ?></th>
                                <td><?= $item['value_lift'] ?></td>
                                <td><?= $item['value_penerangan'] ?></td>
                                <td><?= $item['value_elektronik'] ?></td>
                                <td><?= $item['value_udara'] ?></td>
                                <td><?= $item['value_air'] ?></td>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>

                </div>
            </div>
            <div class="card card-primary">
                <div class="card-body">
                    <h4 class="text-bold text-center">RASIO DAYA HARIAN</h4>
                    <div id="chart2" style="height: 400px;"></div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="<?= base_url('assets-' . app_version() . '/') ?>plugins/jquery/jquery.min.js"></script>
<script src="<?= base_url('assets-' . app_version() . '/') ?>plugins/echarts/echarts.min.js"></script>
<script src="<?= base_url('assets-' . app_version() . '/') ?>dist/js/page7.js" type="module"></script>