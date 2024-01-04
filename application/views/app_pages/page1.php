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
                    <h4 class="text-bold text-center">TABEL PENGUKURAN DAYA LANTAI</h4>
                    <table class="table table-responsive" style="height: 100%;">
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
        </div>
    </div>
</div>
<script src="<?= base_url('assets-' . app_version() . '/') ?>plugins/jquery/jquery.min.js"></script>
<script src="<?= base_url('assets-' . app_version() . '/') ?>plugins/echarts/echarts.min.js"></script>
<script src="<?= base_url('assets-' . app_version() . '/') ?>dist/js/page1.js" type="module"></script>