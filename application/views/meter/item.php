<link rel="stylesheet" href="<?= base_url('assets-' . app_version() . '/') ?>plugins/images-grid/images-grid.css" />
<link rel="stylesheet" href="https://printjs-4de6.kxcdn.com/print.min.css" />
<script src="https://printjs-4de6.kxcdn.com/print.min.js"></script>
<style>
    .dataTables_info {
        display: inline-block !important;
    }

    .pagination {
        margin-bottom: 0 !important;
    }
</style>
<div class="content-header mb-3">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-6">
                <h4 class="m-0 text-dark"><?= $title ?></h4>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right text-sm pl-3 pr-3 mt-2 mt-lg-0">
                    <li class="breadcrumb-item active pointer"><a href="">Manage Item</a></li>
                    <li class="breadcrumb-item text-black"><a class="text-black" href="<?= base_url('meter') ?>"><?= $title ?></a></li>
                    <li class="breadcrumb-item text-black go-back pointer">Home</li>
                </ol>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<input type="hidden" id="meter_sid" value="<?= $meter_sid ?>">
<section class="content">
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card card-primary card-outline">
                        <form role="form" method="post" action="<?= base_url('asset/update') ?>" autocomplete="off">
                            <div class="card-header bg-gray-light">
                                <button id="filter" type="button" class="btn btn-secondary text-primary go-back">
                                    <i class="cil-arrow-left mr-1"></i>
                                </button>
                                <span class="btn btn-secondary text-primary mt-md-0 mt-lg-0 ml-2 cursor-none">
                                    &nbsp;KWH Information
                                </span>
                                <div class="card-tools">
                                    <!-- <button id="print-qr" type="button" class="btn btn-success mr-1" onclick="printJS('print-area', 'html')">
                                        <i class="cil-print mr-1"></i> Print Meter Info
                                    </button> -->
                                    <button id="edit" type="button" class="btn btn-primary">
                                        <i class="cil-pencil mr-1"></i> Update Properties
                                    </button>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-lg-8">
                                        <div class="mx-3 mb-4 d-inline-block">
                                            <h2 class="font-weight-bold" id="meter_name">XXX00000000000000</h2>
                                        </div>

                                        <div title="Show QR Code" data-toggle="tooltip" data-placement="left" class="ml-2 float-right d-inline-block pointer" height="85px" id="data-qr"></div>

                                        <div class="card card-no-border d-block mt-4">
                                            <div class="card-header">
                                                <h3 class="card-title text-danger"><i class="cil-info mr-2 font-weight-bold"></i>General Information</h3>

                                                <div class="card-tools">
                                                    <button type="button" class="btn btn-tool" data-widget="collapse"><i class="cil-minus"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <!-- /.card-header -->
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-lg-6">
                                                        <dl class="row">
                                                            <dt class="col-sm-12">kWh Name (Aliases)</dt>
                                                            <dd class="col-sm-12" id="alias"><?php $this->load->view('_partials/shimmer_text3'); ?></dd>

                                                            <dt class="col-sm-12">KWH Group / Unit</dt>
                                                            <dd class="col-sm-12" id="group"><?php $this->load->view('_partials/shimmer_text4'); ?></dd>

                                                            <dt class="col-sm-12">KWH Series</dt>
                                                            <dd class="col-sm-12" id="serial"><?php $this->load->view('_partials/shimmer_text3'); ?></dd>

                                                            <dt class="col-sm-12">Tarif</dt>
                                                            <dd class="col-sm-12" id="tarif"><?php $this->load->view('_partials/shimmer_text3'); ?></dd>

                                                            <dt class="col-sm-12">PJU (%)</dt>
                                                            <dd class="col-sm-12" id="pju"><?php $this->load->view('_partials/shimmer_text3'); ?></dd>
                                                        </dl>
                                                    </div>
                                                    <div class="col-lg-6">
                                                        <dl class="row">

                                                            <dt class="col-sm-12">Power Contract Factor</dt>
                                                            <dd class="col-sm-12" id="pc_factor"><?php $this->load->view('_partials/shimmer_text3'); ?></dd>

                                                            <dt class="col-sm-12">Power Contract MCCB</dt>
                                                            <dd class="col-sm-12" id="pc_mccb"><?php $this->load->view('_partials/shimmer_text3'); ?></dd>

                                                            <dt class="col-sm-12">Power Contract Daya</dt>
                                                            <dd class="col-sm-12" id="pc_daya"><?php $this->load->view('_partials/shimmer_text3'); ?></dd>

                                                            <dt class="col-sm-12">Location</dt>
                                                            <dd class="col-sm-12" id="location"><?php $this->load->view('_partials/shimmer_text4'); ?></dd>

                                                            <dt class="col-sm-12">Remarks</dt>
                                                            <dd class="col-sm-12" id="remark"><?php $this->load->view('_partials/shimmer_text3'); ?></dd>
                                                            
                                                        </dl>
                                                    </div>
                                                </div>
                                                <!-- /.users-list -->
                                            </div>
                                            <!-- /.card-body -->
                                        </div>

                                        <div class="card">
                                            <div class="card-header">
                                                <h3 class="card-title text-danger"><i class="cil-history font-weight-bold mr-2"></i>Recorded Meter</h3>
                                                <h3 class="card-title text-muted text-xs pl-2"><i class="fas fa-info-circle mr-2 invisible"></i>KWH Meter</h3>

                                                <div class="card-tools">
                                                    <button type="button" class="btn btn-tool" data-widget="collapse"><i class="cil-minus"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="bg-gray-light">
                                                <div class="p-2 mb-0">
                                                    <div class="row">
                                                        <div class="col-lg-12">
                                                            <div class="row">
                                                                <div class="col-lg-6 col-sm-12 mb-2 mb-md-0">
                                                                    <div class="input-group">
                                                                        <div class="input-group-prepend">
                                                                            <span class="input-group-text">
                                                                                <i class="fas fa-search"></i>
                                                                            </span>
                                                                        </div>
                                                                        <input type="text" class="form-control" placeholder="Search" id="search" style="text-transform: unset !important;">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="card-body p-0" style="min-height: 100px">
                                                <div class="shimmer">
                                                    <!-- <?php $this->load->view('_partials/shimmer_no_option_short'); ?> -->
                                                </div>
                                                <table class="table table-sm table-bordered table-striped drag" data-scroll="" id="table-data-record" style="width: 100%; margin-top: 0 !important;">
                                                    <thead>
                                                        
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
                                        </div><!-- /.card -->

                                    </div>

                                    <div class="col-lg-4">

                                        <div class="bg-galery mb-4" style="width: 100%; min-height: 240px">
                                            <div class="transaction-body loading-mask-round loading-image"></div>
                                            <div id="data-photos"></div>
                                        </div>


                                        <div class="card card-no-border">
                                            <div class="card-header">
                                                <h3 class="card-title text-danger"><i class="cil-calendar mr-2 font-weight-bold"></i>Date of Record</h3>

                                                <div class="card-tools">
                                                    <button type="button" class="btn btn-tool" data-widget="collapse"><i class="cil-minus"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <!-- /.card-header -->
                                            <div class="card-body">
                                                <dl class="row">
                                                    <dt class="col-sm-12">Posted Date</dt>
                                                    <dd class="col-sm-12" id="post_date"><?php $this->load->view('_partials/shimmer_text4'); ?></dd>

                                                    <dt class="col-sm-12">Updated Date</dt>
                                                    <dd class="col-sm-12" id="update_date"><?php $this->load->view('_partials/shimmer_text4'); ?></dd>
                                                </dl>
                                                <!-- /.users-list -->
                                            </div>
                                            <!-- /.card-body -->
                                        </div>

                                    </div>

                                </div>
                            </div>
                        </form>

                    </div><!-- /.card -->
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
</section>

<div class="row ml-2 d-none" id="print-area">
    <div class="col-5" id="col">
        <table class="card p-2">
            <tr>
                <td rowspan="3" colspan="2">
                    <div id="data-qr-print"></div>
                </td>
                <td rowspan="3" colspan="2"></td>
            </tr>
            <tr>
                <td class='align-top'>
                    <b class="font-weight-bold ml-2 mt-3" id="td_uid-print"></b><br>
                    <span style="font-size: 10px;" class="font-weight-light ml-2 d-block" id="tube-print"></span><br>
                    <span style="font-size: 10px;" class="font-weight-light ml-2 d-block" id="unit-print"></span><br>
                    <span style="font-size: 10px;" class="font-weight-light ml-2 d-block" id="location-print"></span><br>
                    <span style="font-size: 10px;" class="font-weight-light ml-2 d-block" id="expired-print"></span><br>
                    <span style="font-size: 10px;" class="font-weight-light ml-2 d-block" id="remark-print"></span>
                </td>
            </tr>
            <tr>
                <td class="align-bottom">
                    <span style="font-size: 6px;float:right" class="font-weight-light ml-2 d-block float-right" id="unit-print">&copy; Copyright by <?= app_name() ?></span>
                </td>
            </tr>
        </table>
    </div>
</div>

<script src="<?= base_url('assets-' . app_version() . '/') ?>plugins/jquery/jquery.js"></script>
<script src="<?= base_url('assets-' . app_version() . '/') ?>plugins/images-grid/images-grid.js"></script>
<script src="<?= base_url('assets-' . app_version() . '/') ?>plugins/qrcodejs/qrcode.js"></script>
<script type="module" src="<?= base_url('assets-' . app_version() . '/') ?>dist/js/meter-item.js"></script>

<div class="modal fade" id="imagemodal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h6 id="modal-label">QR CODE : </h6>
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
            </div>
            <div class="modal-body">
                <div class="my-auto mx-auto d-inline" id="imagepreview">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>