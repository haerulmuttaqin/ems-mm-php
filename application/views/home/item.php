<link rel="stylesheet" href="<?= base_url('assets-' . app_version() . '/') ?>plugins/images-grid/images-grid.css" />
<style>
    #gauge {
        width: 100%;
        height: 200px;
    }
</style>
<input type="hidden" id="meter_sid" value="<?php echo $item['meter_sid']; ?>">
<input type="hidden" id="record_value" value="<?php echo $item['record_value']; ?>">
<input type="hidden" id="record_value_before" value="<?php echo $item['record_value_before']; ?>">
<div class="inner-border">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card card-primary card-outline">
                        <form role="form" method="post" action="<?= base_url('asset/update') ?>" autocomplete="off">
                            <div class="card-header bg-gray-light">
                                <button id="filter" type="button" class="btn btn-sm btn-default go-back" title="Go Back" data-toggle="tooltip" data-placement="right">
                                    <i class="cil-arrow-left mr-1 font-weight-bold"></i>
                                </button>
                                <span class="card-title ml-2 font-weight-bold" style="padding-top: 10px !important"><?= $item['meter_name'] ?></span>
                                <div class="card-tools">
                                    <button id="print-qr" type="button" class="btn btn-success mr-1 go-back">
                                        <i class="cil-speedometer mr-1"></i> Show More kWh
                                    </button>
                                    <a href="<?= base_url('meter/item/') . $item['meter_sid'] ?>" type="button" class="btn btn-primary">
                                        <i class="cil-notes mr-1"></i> kWh Properties
                                    </a>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-lg-8">
                                        <div class="row">
                                            <div class="col-lg-4">
                                                <div class="card mb-0" style="background:rgb(30 45 115 / 54%);">
                                                    <div class="panel" style="background-image:url(<?= base_url() . '/assets-' . app_version() . "/dist/img/meter_default.png" ?>); background-size:135%;  background-position: top;  border-radius:10px;">
                                                        <div class="panel-body bg-transparent" style="height:0px">
                                                        </div>
                                                        <div class="panel-footer sidebar-dark-primary-transparent" style="height:110px; bottom:0; border-radius:10px">
                                                            <div class="row pt-2 pr-4 pl-3">
                                                                <span class="col-12 mt-2 text-left text-danger-light font-weight-bold"><small><?= date('d F Y - H:i', strtotime($item['record_date'])) ?></small></span>
                                                                <div class="col-8 text-left mt-2">
                                                                    <div class="border-right border-lightdark">
                                                                        <span class="text-white" style="font-size:29px; font-family:sans-serif; font-weight:bold"><?= formatRp($item['record_value']) ?> <i class="ml-1 text-sm font-weight-bold <?= $item['meter_indicator'] ?>"></i> </span>
                                                                    </div>
                                                                </div>
                                                                <div class="col-2 mt-4 text-left text-sm text-white">
                                                                    <span><small>kWh</small></span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="card mt-0" style="background:rgb(30 45 115 / 54%);">
                                                    <div class="panel" style="background-image:url(<?= base_url() . '/assets-' . app_version() . "/dist/img/meter_default.png" ?>); background-size:135%; background-position: bottom; border-radius:10px;">
                                                        <div class="panel-body bg-transparent" style="height:0px">
                                                        </div>
                                                        <div class="panel-footer sidebar-dark-primary-transparent" style="height:110px; bottom:0; border-radius:10px">
                                                            <div class="row pt-2 pr-4 pl-3">
                                                                <span class="col-12 mt-2 text-left text-danger-light font-weight-bold"><small><?= date('d F Y - H:i', strtotime($item['record_date_before'])) ?></small></span>
                                                                <div class="col-8 text-left mt-2">
                                                                    <div class="border-right border-lightdark">
                                                                        <span class="text-white" style="font-size:29px; font-family:sans-serif; font-weight:bold"><?= formatRp($item['record_value_before']) ?> <i class="ml-1 text-sm cil-history text-white-50"></i></span>
                                                                    </div>
                                                                </div>
                                                                <div class="col-2 mt-4 text-left text-sm text-white">
                                                                    <span><small>kWh</small></span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-8">
                                                <div class="card card-primary">
                                                    <div class="card-body">
                                                        <div id="gauge"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-lg-4">
                                        <div class="bg-galery mb-4" style="width: 100%; min-height: 240px">
                                            <div class="transaction-body loading-mask-round loading-image"></div>
                                            <div id="data-photos"></div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </form>

                        <div id="main" style="height:320px"></div>

                    </div><!-- /.card -->
                </div>
            </div>
        </div>
    </section>
</div>

<script src="<?= base_url('assets-' . app_version() . '/') ?>plugins/jquery/jquery.min.js"></script>
<script src="<?= base_url('assets-' . app_version() . '/') ?>plugins/echarts/echarts.min.js"></script>
<script src="<?= base_url('assets-' . app_version() . '/') ?>dist/js/dashboard.js" type="module"></script>
<script src="<?= base_url('assets-' . app_version() . '/') ?>plugins/images-grid/images-grid.js"></script>