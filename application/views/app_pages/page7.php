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
                    <h4 class="text-bold text-center">PENGUKURAN PEMAKAIAN DAYA</h4>
                    <table class="table" style="height: 100%;">
                        <thead class="thead-dark">
                        <tr>
                            <th scope="col">PEMAKAIAN</th>
                            <th scope="col">TEGANGAN</th>
                            <th scope="col">ARUS RATA RATA</th>
                            <th scope="col">DAYA AKTIF</th>
                            <th scope="col">POWER FACTOR</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <th>LIFT</th>
                            <th>0</th>
                            <td>0</td>
                            <td>0</td>
                            <td>0</td>
                        </tr>
                        <tr>
                            <th>PENERANGAN</th>
                            <th>0</th>
                            <td>0</td>
                            <td>0</td>
                            <td>0</td>
                        </tr>
                        <tr>
                            <th>AC</th>
                            <th>0</th>
                            <td>0</td>
                            <td>0</td>
                            <td>0</td>
                        </tr>
                        <tr>
                            <th>STOP KONTAK</th>
                            <th>0</th>
                            <td>0</td>
                            <td>0</td>
                            <td>0</td>
                        </tr>
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