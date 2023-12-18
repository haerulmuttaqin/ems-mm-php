<div class="container-ems" style="height: 100%;">
    <div class="row">
        <div class="col-lg-6">
            <div class="card card-primary" style="height: 100%;">
                <div class="card-body">
                    <h4 class="text-bold text-center">RASIO DAYA PANEL LANTAI PER BULAN</h4>
                    <div id="main" style="height: 900px;"></div>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="card card-primary">
                <div class="card-body">
                    <h4 class="text-bold text-center">PENGUKURAN DAYA LANTAI</h4>
                    <table class="table" style="height: 100%;">
                        <thead class="thead-dark">
                            <tr>
                                <th scope="col">MEASUREMENT</th>
                                <th scope="col">PM LIFT</th>
                                <th scope="col">PM PENERANGAN DAN STOP KONTAK </th>
                                <th scope="col">PM ELEKTRONIK</th>
                                <th scope="col">PM TATA UDARA</th>
                                <th scope="col">PM TATA AIR</th>
                            </tr>
                        </thead>
                        <?php foreach ($data as $item) : ?>
                        <tbody>
                            <tr>
                                <th><?= $item['caption'] ?></th>
                                <th><?= $item['value_lift'] ?></th>
                                <td><?= $item['value_penerangan'] ?></td>
                                <td><?= $item['value_elektronik'] ?></td>
                                <td><?= $item['value_udara'] ?></td>
                                <td><?= $item['value_air'] ?></td>
                            </tr>
                        </tbody>
                        <?php endforeach; ?>
                    </table>

                </div>
            </div>
        </div>
    </div>
</div>
<script src="<?= base_url('assets-' . app_version() . '/') ?>plugins/jquery/jquery.min.js"></script>
<script src="<?= base_url('assets-' . app_version() . '/') ?>plugins/echarts/echarts.min.js"></script>
<script src="<?= base_url('assets-' . app_version() . '/') ?>dist/js/page1.js" type="module"></script>