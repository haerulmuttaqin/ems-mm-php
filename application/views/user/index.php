<!-- Main content -->
<section class="content">

    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card card-primary card-outline">
                        <div class="card-header bg-gray-light">
                            <button id="filter" type="button" class="btn btn-secondary go-back" title="Go Back" data-toggle="tooltip" data-placement="right">
                                <i class="cil-arrow-left mr-1 font-weight-bold text-primary"></i>
                            </button>
                            <div class="card-tools">
                                <a href="<?= base_url('user/add') ?>" class="btn btn-primary modalAddMenu">
                                    <i class="cil-plus mr-1"></i> Create New User
                                </a>
                            </div>
                        </div>
                        <div class="card-body" style="min-height: 480px !important;">
                            <div class="shimmer">
                                <?php $this->load->view('_partials/shimmer'); ?>
                            </div>
                            <table class="table table-sm table-bordered table-striped" id="user-table" style="width: 100%; margin-top: 0 !important;">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>User UID</th>
                                        <th>No. Induk</th>
                                        <th>Nama User</th>
                                        <th>Unit</th>
                                        <th>User Role</th>
                                        <th>Status</th>
                                        <th>Last Login</th>
                                        <th>Last Sync</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                            </table>
                            <div id="transaction-body"></div>
                        </div>
                        <div class="card-footer" style="display: block;">
                            <div class="row">
                                <div class="col-sm-12 col-md-5">
                                    <span class="" id="info"></span>
                                </div>
                                <div class="col-sm-12 col-md-7 float-right">
                                    <div class="dataTables_paginate paging_simple_numbers" id="table-data-record_paginate">
                                        <div class="float-right">
                                            <span id="page"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div><!-- /.card -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php $this->load->view('_partials/footer'); ?>
<script src="<?= base_url('assets-' . app_version() . '/') ?>dist/js/user.js" type="module"></script>