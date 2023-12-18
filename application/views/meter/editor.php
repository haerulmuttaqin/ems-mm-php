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
<input type="hidden" id="sid" value="<?= $sid ?>">
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <!-- connectedSortable ui-sortable -->
                <form id="tube-form" data-parsley-validate>
                    <div class="card card-primary card-outline">
                        <div class="card-header bg-gray-light ui-sortable-handle" style="cursor: move;">
                            <button id="filter" type="button" class="btn btn-secondary text-primary go-back">
                                <i class="cil-arrow-left mr-1"></i>
                            </button>
                            <span id="label-datatabung" class="btn btn-secondary text-primary ml-2 mt-lg-0">
                                &nbsp; ...
                            </span>
                            <div class="card-tools">
                                <button type="button" class="collapseble btn btn-tool" data-widget="collapse" data-toggle="tooltip" title="Minimize">
                                    <i class="text-black cil-window-minimize"></i>
                                </button>
                                <button type="button" class="btn btn-tool" data-widget="remove" data-toggle="tooltip" title="Close">
                                    <i class="text-black cil-x"></i>
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row mt-1">
                                <div class="col-lg-6">

                                    <div class="form-group row">
                                        <label for="meter_group" class="col-sm-3 col-form-label text-lg-right text-truncate">Group</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" id="meter_group" disabled>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="meter_name" class="col-sm-3 col-form-label text-lg-right text-truncate">kWh Name</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" id="meter_name" disabled>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="meter_alias" class="col-sm-3 col-form-label text-lg-right text-truncate">Alias Name</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" id="meter_alias">
                                            <small id="emailHelp" class="form-text text-muted"><i class="fas fa-info-circle"></i> Will be displayed as a title or name.</small>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="meter_serial" class="col-sm-3 col-form-label text-lg-right text-truncate">kWh Series</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" id="meter_serial">
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="meter_tarif" class="col-sm-3 col-form-label text-lg-right text-truncate">Tarif</label>
                                        <div class="col-sm-9">
                                            <input type="number" class="form-control" id="meter_tarif">
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="meter_name" class="col-sm-3 col-form-label text-lg-right text-truncate">Image</label>
                                        <div class="card-no-shadow card-secondary card-outline ml-2">
                                            <div class="card-body box-profile">
                                                <div class="text-center">
                                                    <a class="text-center pointer" data-toggle="tooltip" data-placement="bottom" title="Update Image">
                                                        <?php
                                                        $default =base_url('assets-' . app_version() . '/') . 'dist/img/no-image.png';
                                                        if ($image['data'] != null) {
                                                            $default = 'data:image/jpeg;base64,' . $image['data'];
                                                        }
                                                        ?>
                                                        <img class="cursor-pointer profile-user-img img-fluid" src="<?= $default ?>" data-toggle="modal" data-target="#avatar-modal" id="render-avatar" class="has-shadow border marg-top10" data-ussuid="<?php print base64_encode(1); ?>" data-backdrop="static" data-keyboard="false" data-upltype="avatar">
                                                    </a>
                                                </div>

                                            </div>
                                            <!-- /.card-body -->
                                        </div>
                                        <small class="text-gray mt-2 col-sm-4 ml-2"><i class="fas fa-info-circle"></i> hover to image for change<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;format file : jpg or png.</small>
                                    </div>

                                </div>

                                <div class="col-lg-6">

                                    <div class="col-lg-12 row">
                                        <label class="col-form-label col-lg-12 text-gray">Power Contract : </label>
                                        <div class="col-lg-4">
                                            <div class="form-group row">
                                                <label for="meter_pc_factor" class="col-sm-12 col-form-label text-lg-left text-truncate">Factor</label>
                                                <div class="col-sm-12">
                                                    <input type="text" class="form-control" id="meter_pc_factor">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-lg-4">
                                            <div class="form-group row">
                                                <label for="meter_pc_mccb" class="col-sm-12 col-form-label text-lg-left text-truncate">MCCB</label>
                                                <div class="col-sm-12">
                                                    <input type="text" class="form-control" id="meter_pc_mccb">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-lg-4">
                                            <div class="form-group row">
                                                <label for="meter_pc_daya" class="col-sm-12 col-form-label text-lg-left text-truncate">Daya</label>
                                                <div class="col-sm-12">
                                                    <input type="text" class="form-control" id="meter_pc_daya">
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-lg-6 row">
                                        <div class="form-check col-sm-12 ml-2">
                                            <input class="form-check-input" type="checkbox" value="" id="flexCheck">
                                            <label class="form-check-label" for="flexCheck">
                                                Set as custom value PJU (%)
                                            </label>
                                        </div>
                                        <div class="col-sm-12 mt-1">
                                            <input type="text" class="form-control" id="meter_pju">
                                        </div>
                                    </div>

                                    <div class="col-lg-12 mt-2 row">
                                        <label for="remark" class="col-sm-12 col-form-label text-lg-left text-truncate">Location / Unit</label>
                                        <div class="col-sm-12">
                                            <input type="text" class="form-control" id="location">
                                        </div>
                                    </div>
                                    
                                    <div class="col-lg-12 mt-2 row">
                                        <label for="remark" class="col-sm-12 col-form-label text-lg-left text-truncate">Remarks</label>
                                        <div class="col-sm-12">
                                            <input type="text" class="form-control" id="remark">
                                        </div>
                                    </div>


                                </div>

                            </div>
                        </div>
                        <div class="card-footer">
                            <button id="submit" type="button" class="btn btn-success float-right"><i class="cil-check-alt mr-1"></i> Submit Changes</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

    </div>
</section>

<!-- Cropping modal -->
<div id="crop-avatar">
    <div class="modal fade" id="avatar-modal" aria-hidden="true" aria-labelledby="avatar-modal-label" role="dialog" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content panel-primary">
                <form class="avatar-form" action="<?= base_url(); ?>meter/upload" enctype="multipart/form-data" method="post">
                    <div class="modal-header panel-heading">
                        <h4 class="modal-title">Change Image</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        <!-- Upload image and data -->
                        <div class="row">
                            <div class="col-md-12">
                                <div class="input-group">
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input filestyle avatar-input" id="avatarInput" name="avatar_file">
                                        <label class="custom-file-label" for="exampleInputFile">Choose file</label>
                                    </div>
                                    <div class="input-group-append">
                                        <span class="input-group-text" id="">Upload</span>
                                    </div>
                                </div>
                            </div>
                            <!-- Crop and preview -->
                            <div class="col-md-12">
                                <div class="avatar-wrapper"></div>
                            </div>
                            <div class="avatar-upload">
                                <input type="hidden" id="data_sid" class="uss-id" name="data_sid" value="<?= $sid ?>">
                                <input type="hidden" class="avatar-src" name="avatar_src">
                                <input type="hidden" class="avatar-data" name="avatar_data">
                            </div>
                        </div>

                    </div>
                    <div class="modal-footer panel-footer">
                        <button type="button" class="avatar-btns btn btn-light" data-method="rotate" data-option="-90" title="Rotate the image 9 degree to the left"><i class="fas fa-undo"></i> Rotate
                        </button>


                        <button type="button" class="avatar-btns btn btn-light" data-method="rotate" data-option="-90" title="Rotate the image 9 degree to the right"><i class="fas fa-redo"></i> Rotate
                        </button>
                        <button type="submit" class="btn btn-primary avatar-save">Crop & Save</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    </div>
                </form>
            </div>
        </div>
    </div><!-- /.modal -->
</div>
<!-- Loading state -->
<div class="loading" aria-label="Loading" role="img" tabindex="-1"></div>

<script src="<?= base_url('assets-' . app_version() . '/') ?>plugins/jquery/jquery-3.3.1.js"></script>
<script src="<?= base_url('assets-' . app_version() . '/') ?>plugins/crop/js/cropper.js"></script>
<script src="<?= base_url('assets-' . app_version() . '/') ?>plugins/crop/js/main-image.js" type="module"></script>
<script type="module" src="<?= base_url('assets-' . app_version() . '/') ?>dist/js/meter-editor.js"></script>