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
                    <li class="breadcrumb-item active"><a href=""><?= $title ?></a></li>
                    <li class="breadcrumb-item text-black go-back pointer">Home</li>
                </ol>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
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
                                        <div class="col-lg-3 col-sm-6">
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text">
                                                        <i class="cil-search"></i>
                                                    </span>
                                                </div>
                                                <input type="text" class="form-control" placeholder="Search" id="search" style="text-transform: unset !important;">
                                            </div>
                                        </div>
                                        <div class="col-lg-3 col-sm-6">
                                            <div class="input-group">
                                                <select class="form-control select2" name="s_group" id="s_group" style="width: 100% !important;">
                                                    <option selected class="text-light" value="">All Groups</option>
                                                </select>
                                            </div>
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
                        <table class="table table-sm table-bordered table-striped drag" data-scroll="" id="table-data-record" style="width: 100%; margin-top: 0 !important;">
                            <thead>
                                <tr class="enable-border">
                                    <th class="align-middle">#</th>
                                    <th class="align-middle">KWH GROUP / UNIT</th>
                                    <th class="align-middle">KWH SERIES</th>
                                    <th class="align-middle">KWH NAME</th>
                                    <th class="align-middle">ALIASES</th>
                                    <th class="align-middle">UPDATE DATETIME</th>
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
<script src="<?= base_url('assets-' . app_version() . '/') ?>plugins/dragscroll/jquery.dragscroll.js"></script>
<script type="module" src="<?= base_url('assets-' . app_version() . '/') ?>dist/js/meter.js"></script>
<script>
    $('.drag').dragscroll({
        onStart: function($this) {
            $(this).addClass('grabing');
            $(this).removeClass('grab');
            sessionStorage.setItem("drag_time", 'start');
        },
        onMove: function($this) {
            if ($(".dataTables_scrollBody").scrollLeft() > 0) {
                $('.DTFC_LeftHeadWrapper').find('table').addClass('border-right-line');
                $('.DTFC_LeftBodyWrapper').addClass('border-right-line');
            } else {
                $('.DTFC_LeftHeadWrapper').find('table').removeClass('border-right-line');
                $('.DTFC_LeftBodyWrapper').removeClass('border-right-line');
            }
        },
        onEnd: function($this) {
            $(this).addClass('grab');
            $(this).removeClass('grabing');
            sessionStorage.setItem("drag_time", 'end');
        }
    });
</script>