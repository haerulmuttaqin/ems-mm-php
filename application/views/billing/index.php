<style>
    .dataTables_info {
        display: inline-block !important;
    }

    .pagination {
        margin-bottom: 0 !important;
    }

    .table-bordered1 {
        border: 0.2px solid #111;
    }

    .table-bordered1 th,
    .table-bordered1 td {
        border: 0.1px solid #111;
        padding-top: 2px;
        padding-bottom: 2px;
        padding-left: 7px;
        padding-right: 7px;
    }

    .table-bordered1 thead th,
    .table-bordered1 thead td {
        border-bottom-width: 0.3px;
        padding-top: 2px;
        padding-bottom: 2px;
        padding-left: 7px;
        padding-right: 7px;
    }

    .table-0 thead td {
        border-bottom-width: 0.3px;
        padding-top: 2px;
        padding-bottom: 2px;
        padding-left: 5px;
        padding-right: 5px;
    }

    .hr-dashed {
        border-top: 0.5px dashed gray;
        width: 100%
    }
</style>
<input type="hidden" id="meter_last_record" value="<?php echo $meter_last_record; ?>">
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card card-primary card-outline">
                    <div class="card-header bg-gray-light" id="card-header">
                        <div class="pt-0 pb-0 mb-0">
                            <div class="row">
                                <div class="col-lg-11">
                                    <div class="row">
                                        <div class="col-lg-5 col-sm-12 mt-2">
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text">
                                                        <i class="far fa-calendar-alt"></i>
                                                    </span>
                                                </div>
                                                <input placeholder="[Select Date Range]" type="text" class="form-control float-right" style="text-transform: none !important;" id="report_filter" autocomplete="off">
                                            </div>
                                        </div>
                                        <div class="col-lg-3 col-sm-6 mt-2">
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text">
                                                        <i class="cil-search"></i>
                                                    </span>
                                                </div>
                                                <input type="text" class="form-control" placeholder="Search" id="search" style="text-transform: unset !important;">
                                            </div>
                                        </div>
                                        <div class="col-lg-3 col-sm-6 mt-2">
                                            <button id="export-data" type="submit" class="btn btn-success text-truncate ">
                                                <i class="cil-data-transfer-down mr-1"></i> Export All to Excel
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-1 col-sm-12">
                                    <div class="row">
                                        <div class="col-6">
                                            <button id="refresh-table" type="button" class="btn btn-file float-lg-right float-sm-left" title="Refresh table" data-toggle="tooltip" data-placement="bottom">
                                                <i class="cil-sync"></i>
                                            </button>
                                        </div>
                                        <div class="col-6">
                                            <button id="collexp" type="button" class="btn btn-file float-right" title="More options" data-toggle="tooltip" data-placement="bottom">
                                                <i class="fas fa-caret-down"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body p-0" style="min-height: 400px">
                        <div class="shimmer" style="padding-left: 0; padding-right: 0;">
                            <?php $this->load->view('_partials/shimmer_no_option'); ?>
                        </div>
                        <table class="table table-sm table-bordered table-striped" data-scroll="" id="table-data-record" style="width: 100%; margin-top: 0 !important;">
                            <thead>
                                <tr class="enable-border">
                                    <th class="align-middle" rowspan="2">#</th>
                                    <th class="align-middle text-center" rowspan="2">KWH NAME</th>
                                    <th class="align-middle text-center" colspan="3">METER</th>
                                    <th class="align-middle text-center" colspan="3">LWBP</th>
                                    <th class="align-middle text-center" colspan="3">WBP</th>
                                    <th class="align-middle text-center" rowspan="2">SUBTOTAL</th>
                                    <th class="align-middle text-center" rowspan="2">PJU (%)</th>
                                    <th class="align-middle text-center" rowspan="2">TOTAL</th>
                                    <th class="align-middle text-center" rowspan="2"><b>ACTION</b></th>
                                </tr>
                                <tr class="enable-border">
                                    <th class="align-middle">START</th>
                                    <th class="align-middle">END</th>
                                    <th class="align-middle">TOTAL</th>
                                    <th class="align-middle">USAGE</th>
                                    <th class="align-middle">TARIF</th>
                                    <th class="align-middle">COST</th>
                                    <th class="align-middle">USAGE</th>
                                    <th class="align-middle">TARIF</th>
                                    <th class="align-middle">COST</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                    <div class="card-footer" style="display: block;">
                        <div class="row">
                            <div class="col-lg-1 col-sm-1">
                                <div class="dataTables_length" id="lenght">
                                    <select name="table-data-record_length" style="width: 60px" class="form-control form-control-sm select2">
                                        <option value="">10</option>
                                        <option value="">25</option>
                                        <option value="">50</option>
                                        <option value="">100</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-5 col-sm-5">
                                <div class="mt-2">
                                    <span class="ml-3" id="info"></span>
                                </div>
                            </div>
                            <div class="col-sm-6 col-lg-6 float-right">
                                <div class="dataTables_paginate paging_simple_numbers" id="table-data-record_paginate">
                                    <div class="float-right">
                                        <span id="page"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script src="<?= base_url('assets-' . app_version() . '/') ?>plugins/jquery/jquery.js"></script>
<script src="<?= base_url('assets-' . app_version() . '/') ?>plugins/jspdf/html2canvas.js"></script>
<script type="module" src="<?= base_url('assets-' . app_version() . '/') ?>plugins/jspdf/jspdf.umd.min.js"></script>
<script type="module" src="<?= base_url('assets-' . app_version() . '/') ?>dist/js/billing.js"></script>
<div class="p-4" id="print-area" style="display:none">
    <div class="text-center"><img id="header-img" src="http://localhost/2021/ems.yodyatower/assets-0.0.1/dist/img/no-image.png" width="120"></div>
    <br>
    <h5 class="text-center" id="header-title">Title</h5>
    <p class="text-left" id="header-address">Address</p>
    <hr class="hr-dashed">
    <h5>TENANT INFORMATION</h5>
    <table class="table-0">
        <tr>
            <td>NAME</td>
            <td> &nbsp;: </td>
            <td id="name"></td>
        </tr>
        <tr>
            <td>PERIOD</td>
            <td> &nbsp;: </td>
            <td id="period"></td>
        </tr>
    </table>
    <br>
    <table class="table-bordered1" style="width: 100%;">
        <thead>
            <tr class="enable-border">
                <th class="align-middle" rowspan="2">NO.</th>
                <th class="align-middle text-center" rowspan="2">LOCATION/UNIT</th>
                <th class="align-middle text-center" rowspan="2">NO. SERIAL</th>
                <th class="align-middle text-center" rowspan="2">TARIF</th>
                <th class="align-middle text-center" colspan="3">POWER CONTRACT</th>
                <th class="align-middle text-center" colspan="2">USAGE</th>
                <th class="align-middle text-center" colspan="2">TARIF (Rp)</th>
                <th class="align-middle text-center" colspan="2">COST (Rp)</th>
                <th nowrap="nowrap" class="align-middle text-center" rowspan="2">SUBTOTAL</th>
                <th nowrap="nowrap" class="align-middle text-center" rowspan="2" id="pju_label">PJU (%)</th>
                <th nowrap="nowrap" class="align-middle text-center" rowspan="2">TOTAL (Rp)</th>
            </tr>
            <tr class="enable-border">
                <th class="align-middle">FACTOR</th>
                <th class="align-middle">MCCB</th>
                <th class="align-middle">DAYA</th>
                <th class="align-middle">LWBP</th>
                <th class="align-middle">WBP</th>
                <th class="align-middle">LWBP</th>
                <th class="align-middle">WBP</th>
                <th class="align-middle">LWBP</th>
                <th class="align-middle">WBP</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>&nbsp;1.&nbsp;</td>
                <td nowrap="nowrap" id="location">&nbsp;</td>
                <td nowrap="nowrap" id="serial">&nbsp;</td>
                <td class="text-right" nowrap="nowrap" id="tarif">&nbsp;</td>
                <td class="text-right" nowrap="nowrap" id="factor">&nbsp;</td>
                <td class="text-right" nowrap="nowrap" id="mccb">&nbsp;</td>
                <td class="text-right" nowrap="nowrap" id="daya">&nbsp;</td>
                <td class="text-right" nowrap="nowrap" id="lwbp_usage">&nbsp;</td>
                <td class="text-right" nowrap="nowrap" id="wbp_usage">&nbsp;</td>
                <td class="text-right" nowrap="nowrap" id="lwbp_tarif">&nbsp;</td>
                <td class="text-right" nowrap="nowrap" id="wbp_tarif">&nbsp;</td>
                <td class="text-right" nowrap="nowrap" id="lwbp_cost">&nbsp;</td>
                <td class="text-right" nowrap="nowrap" id="wbp_cost">&nbsp;</td>
                <td class="text-right" nowrap="nowrap" id="subtotal">&nbsp;</td>
                <td class="text-right" nowrap="nowrap" id="pju">&nbsp;</td>
                <td class="text-right" nowrap="nowrap" id="total">&nbsp;</td>
            </tr>
            <tr>
                <th colspan="13">&nbsp;</th>
                <th nowrap="nowrap" colspan="2"><b>TOTAL</b></th>
                <th nowrap="nowrap" class="text-right" id="total2">&nbsp;</th>
            </tr>
            <tr>
                <th colspan="13">&nbsp;</th>
                <th nowrap="nowrap" colspan="2"><b id="ppn_label">PPN</b></th>
                <th nowrap="nowrap" class="text-right" id="ppn">&nbsp;</th>
            </tr>
            <tr>
                <th colspan="13">&nbsp;</th>
                <th nowrap="nowrap" colspan="2"><b>GRAND TOTAL</b></th>
                <th nowrap="nowrap" class="text-right" id="grand_total">&nbsp;</th>
            </tr>
        </tbody>
    </table>
    <br>
    <br>
    <span class="text-left font-weight-bold"><?php echo date('d F Y', time()) ?></span>
    <br>
    <span>Mengetahi,</span>
    <br><br><br>
    ———————————————
    <br>
    <b id="pic"></b>
</div>