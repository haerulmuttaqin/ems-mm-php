<div class="container-ems" style="height: 100%;">
    <div class="row">
        <div class="col-lg-6">
            <div class="card card-primary" style="height: 100%;">
                <div class="card-body">
                    <h5 class="text-bold text-center">TREND DAYA PAKAI HARIAN TERHADAP HARI YANG
                        SAMA BULAN LALU
                    </h5>
                    <div id="chart1" style="height: 270px;"></div>
                    <h5 class="text-bold text-center">TREND DAYA 1 HARIAN TERHADAP HARI YANG SAMA
                        MINGGU LALU</h5>
                    <div id="chart2" style="height: 270px;"></div>
                    <h5 class="text-bold text-center">TREND HARIAN TERHADAP MINGGUAAN</h5>
                    <div id="chart3" style="height: 270px;"></div>

                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="card card-primary">
                <div class="card-body">
                    <h4 class="text-bold text-center">TABEL PENGUKURAN UTAMA</h4>
                    <table class="table" style="height: 100%;">
                        <thead class="thead-dark">
                        <tr>
                            <th scope="col">Measuerement</th>
                            <th scope="col">PM Stop Kontak Lantai</th>
                            <th scope="col">PM AC/AHU</th>
                            <th scope="col">PM Penerangan</th>
                            <th scope="col">PM Lift</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <th>Current Avg</th>
                            <th>0</th>
                            <td>0</td>
                            <td>0</td>
                            <td>0</td>
                        </tr>
                        <tr>
                            <th>Frequency</th>
                            <th>0</th>
                            <td>0</td>
                            <td>0</td>
                            <td>0</td>
                        </tr>
                        <tr>
                            <th>Power Factor</th>
                            <th>0</th>
                            <td>0</td>
                            <td>0</td>
                            <td>0</td>
                        </tr>
                        <tr>
                            <th>Measuerement dummy</th>
                            <th>0</th>
                            <td>0</td>
                            <td>0</td>
                            <td>0</td>
                        </tr>
                        <tr>
                            <th>Measuerement dummy</th>
                            <th>0</th>
                            <td>0</td>
                            <td>0</td>
                            <td>0</td>
                        </tr>
                        <tr>
                            <th>Measuerement dummy</th>
                            <th>0</th>
                            <td>0</td>
                            <td>0</td>
                            <td>0</td>
                        </tr>
                        </tbody>
                    </table>

                </div>
            </div>
        </div>
    </div>
</div>
<script src="<?= base_url('assets-' . app_version() . '/') ?>plugins/jquery/jquery.min.js"></script>
<script src="<?= base_url('assets-' . app_version() . '/') ?>plugins/echarts/echarts.min.js"></script>
<script src="<?= base_url('assets-' . app_version() . '/') ?>dist/js/page2.js" type="module"></script>