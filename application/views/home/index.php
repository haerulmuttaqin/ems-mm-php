<div class="inner-border">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row">

                <?php foreach ($meters as $item) :

                    $image = base_url() . '/assets-'. app_version() . "/dist/img/meter_default.png";

                    if ($item['image'] != null) {
                        $image = 'data:image/png;base64,' . $item['image'];
                    }

                ?>

                    <div class="col-md-3 col-sm-2 col-lg-2 mb-3 animated bounceInleft">
                        <a href="<?= base_url() ?>dashboard/item/<?= $item['meter_sid'] ?>" title="<?= $item['meter_name'] . ' - ' .  $item['meter_text'] ?> dibandingan dengan bulan sebelum ditanggal yg sama.">
                            <div class="service-box">
                                <div class="service-icon white " style="height:170px;">
                                    <div class="front-content" style="top:85px;">
                                        <div class="panel" style="background-image:url(<?= $image ?>); background-size:135%;">
                                            <div class="pt-3 pb-2 sidebar-dark-primary text-white">
                                                <span class="text-center text-sm font-weight-medium"><?= $item['meter_name'] ?></span>
                                            </div>
                                            <div class="panel-body bg-transparent" style="height:85px">
                                            </div>
                                            <div class="panel-footer" style="background:rgba(255,255,255,0.8); height:40px; bottom:0; ">
                                                <div class="row pt-2 pr-4">
                                                    <div class="col-9 text-center">
                                                        <div class="border-right border-darklight">
                                                            <span class="text-danger" style="font-size:14px; font-family:sans-serif; font-weight:bold"><?= formatRp($item['record_value']) ?></span>
                                                        </div>
                                                    </div>
                                                    <div class="col-2 text-center text-sm text-danger font-weight:bold">
                                                        <span><small>kWh</small></span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="service-content" style="height:170px; background-image:url(<?= base_url() . '/assets-'. app_version() . "/dist/img/meter_default.png" ?>); background-size:120%;">
                                    <div style="background:rgb(30 45 115 / 54%); width:135%; height:250px; margin-left:-20px; margin-top:-20px;">
                                        <div class="panel" style="background-image:url(<?= $image ?>); background-size:135%;">
                                            <div class="pt-3 pb-2 text-danger font-weight-bold" style="background:rgba(255,255,255,0.6);">
                                                <span class="text-center text-sm font-weight-bold"><?= $item['meter_name'] ?></span>
                                            </div>
                                            <div class="panel-body bg-transparent" style="height:0px">
                                            </div>
                                            <div class="panel-footer sidebar-dark-primary-transparent" style="height:120px; bottom:0; ">
                                                <div class="row pt-2 pr-4 pl-3">
                                                    <span class="col-12 text-left text-danger-light text-sm font-weight-bold"><small><?= date('d F Y - H:i', strtotime($item['record_date'])) ?></small></span>
                                                    <div class="col-8 text-left">
                                                        <div class="border-right border-lightdark">
                                                            <span class="text-white" style="font-size:14px; font-family:sans-serif; font-weight:bold"><?= formatRp($item['record_value']) ?> <i class="ml-1 text-sm font-weight-bold <?= $item['meter_indicator'] ?>"></i> </span>
                                                        </div>
                                                    </div>
                                                    <div class="col-2 text-left text-sm text-white">
                                                        <span><small>kWh</small></span>
                                                    </div>
                                                </div>
                                                <div class="row pt-2 pr-4 pl-3">
                                                    <span class="col-12 text-left text-danger-light text-sm font-weight-bold"><small><?= date('d F Y - H:i', strtotime($item['record_date_before'])) ?></small></span>
                                                    <div class="col-8 text-left">
                                                        <div class="border-right border-lightdark">
                                                            <span class="text-white" style="font-size:14px; font-family:sans-serif; font-weight:bold"><?= formatRp($item['record_value_before']) ?> <i class="ml-1 text-sm cil-history text-white-50"></i></span>
                                                        </div>
                                                    </div>
                                                    <div class="col-2 text-left text-sm text-white">
                                                        <span><small>kWh</small></span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>

                <?php endforeach; ?>

            </div>

        </div>
    </section>
</div>


<script src="<?= base_url('assets-' . app_version() . '/') ?>plugins/jquery/jquery.min.js"></script>
<script src="<?= base_url('assets-' . app_version() . '/') ?>plugins/echarts/echarts.min.js"></script>
<script src="<?= base_url('assets-' . app_version() . '/') ?>dist/js/dashboard.js" type="module"></script>