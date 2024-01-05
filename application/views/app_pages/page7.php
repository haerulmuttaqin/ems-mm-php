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
                            <th scope="col" style="vertical-align: middle;">MEASUREMENT</th>
                            <?php foreach ($data['header'] as $item) : ?>
                                <th scope="col" style="vertical-align: middle;"><?= $item['caption'] ?></th>
                            <?php endforeach; ?>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($data['body'] as $item) : ?>
                            <tr>
                                <th><?= $item['caption'] ?></th>
                                <?php foreach ($data['header'] as $item_header) : ?>
                                    <td><?= $item[str_replace(" ", "_", $item_header['key'])] ?: "-" ?></td>
                                <?php endforeach; ?>
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