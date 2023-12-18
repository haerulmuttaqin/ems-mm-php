<section class="content">
    <div class="container-fluid">
        <div class="row">
            <!-- /.col -->
            <div class="col-md-12">
                <div class="card card-secondary card-outline">
                    <div class="card-header bg-gray-light">
                        <button id="filter" type="button" class="btn btn-sm btn-default go-back" title="Go Back" data-toggle="tooltip" data-placement="right">
                            <i class="cil-arrow-left mr-1 font-weight-bold"></i>
                        </button>
                        <span class="card-title ml-2">Configuration Billing Information</span>
                    </div>
                    <div class="card-body" style="padding-bottom: 20px !important;">
                        <div class="tab-content">
                            <!-- /.tab-pane -->
                            <div class="tab-pane active" id="settings">
                                <form role="form" method="post" action="<?= base_url('billconfig/update') ?>" autocomplete="off">
                                    <input type="hidden" name="id" value="<?= $data['bill_config_id'] . set_value('app_sid'); ?>">

                                    <div class="row">

                                        <div class="col-lg-9">

                                            <div class="row">
                                                <div class="col-lg-6">
                                                    <div class="form-group">
                                                        <label for="bill_config_vat">VAT (%)</label>
                                                        <input type="text" class="form-control" autocapitalize="off" autocomplete="off" name="bill_config_vat" id="bill_config_vat" value="<?= $data['bill_config_vat'] . set_value('bill_config_vat'); ?>">
                                                        <?= form_error('bill_config_vat', '<small class="text-danger">', '</small>') ?>
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="bill_config_pju">PJU (%)</label>
                                                        <input type="text" class="form-control" autocapitalize="off" autocomplete="off" name="bill_config_pju" id="bill_config_pju" value="<?= $data['bill_config_pju'] . set_value('bill_config_pju'); ?>">
                                                        <?= form_error('bill_config_pju', '<small class="text-danger">', '</small>') ?>
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="bill_config_lwbp">LWBP (Rp)</label>
                                                        <input type="number" name="bill_config_lwbp" autocapitalize="off" class="form-control" id="bill_config_lwbp" value="<?= $data['bill_config_lwbp'] . set_value('bill_config_lwbp'); ?>">
                                                        <?= form_error('bill_config_lwbp', '<small class="text-danger">', '</small>') ?>
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="bill_config_wbp">WBP (Rp)</label>
                                                        <input type="number" name="bill_config_wbp" autocapitalize="off" class="form-control" id="bill_config_wbp" value="<?= $data['bill_config_wbp'] . set_value('bill_config_wbp'); ?>">
                                                        <?= form_error('bill_config_wbp', '<small class="text-danger">', '</small>') ?>
                                                    </div>

                                                    <div class="row">

                                                        <div class="col-lg-6">

                                                            <div class="form-group">
                                                                <label for="bill_config_wbp_start_time">WBP Start Time</label>
                                                                <input type="text" name="bill_config_wbp_start_time" class="form-control" id="bill_config_wbp_start_time" value="<?= $data['bill_config_wbp_start_time'] . set_value('bill_config_wbp_start_time'); ?>">
                                                                <?= form_error('bill_config_wbp_start_time', '<small class="text-danger">', '</small>') ?>
                                                            </div>

                                                        </div>

                                                        <div class="col-lg-6">

                                                            <div class="form-group">
                                                                <label for="bill_config_wbp_end_time">WBP End Time</label>
                                                                <input type="text" name="bill_config_wbp_end_time" class="form-control" id="bill_config_wbp_end_time" value="<?= $data['bill_config_wbp_end_time'] . set_value('bill_config_wbp_end_time'); ?>">
                                                                <?= form_error('bill_config_wbp_end_time', '<small class="text-danger">', '</small>') ?>
                                                            </div>
                                                        </div>

                                                    </div>


                                                </div>
                                                <!--close row 1-->

                                                <div class="col-lg-6">

                                                    <div class="form-group">
                                                        <label for="bill_config_pic">PIC</label>
                                                        <input type="text" name="bill_config_pic" autocapitalize="on" class="form-control" id="bill_config_pic" value="<?= $data['bill_config_pic'] . set_value('bill_config_pic'); ?>">
                                                        <?= form_error('bill_config_pic', '<small class="text-danger">', '</small>') ?>
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="bill_config_invoice_title">Invoice Title</label>
                                                        <input type="text" name="bill_config_invoice_title" class="form-control" id="bill_config_invoice_title" value="<?= $data['bill_config_invoice_title'] . set_value('bill_config_invoice_title'); ?>">
                                                        <?= form_error('bill_config_invoice_title', '<small class="text-danger">', '</small>') ?>
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="bill_config_address">Address</label>
                                                        <textarea style="height: 123px;" type="bill_config_address" name="bill_config_address" class="form-control" id="bill_config_address"><?= $data['bill_config_address'] . set_value('bill_config_address'); ?></textarea>
                                                        <?= form_error('bill_config_address', '<small class="text-danger">', '</small>') ?>
                                                    </div>

                                                </div>
                                            </div>

                                        </div>

                                        <div class="col-lg-3">

                                            <div class="form-group">
                                                <label for="bill_config_pic">Logo</label>
                                                <div class="card-no-shadow card-primary card-outline">
                                                    <div class="card-body box-profile">
                                                        <center>
                                                            <a href="#" class="text-center" data-toggle="tooltip" data-placement="bottom" title="Update Logo">
                                                                <?php
                                                                $default = 'data:image/jpeg;base64,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';
                                                                if ($data['bill_config_logo'] != null) {
                                                                    $default = 'data:image/jpeg;base64,' . $data['bill_config_logo'];
                                                                }
                                                                ?>
                                                                <img class="profile-user-img img-fluid" src="<?= $default ?>" data-toggle="modal" data-target="#avatar-modal" id="render-avatar" class="has-shadow border marg-top10" data-ussuid="<?php print base64_encode(1); ?>" data-backdrop="static" data-keyboard="false" data-upltype="avatar">
                                                            </a>
                                                        </center>

                                                    </div>
                                                    <!-- /.card-body -->
                                                </div>
                                                <small class="text-gray mt-2"><i class="fas fa-info-circle"></i> hover to image for change</small>
                                            </div>
                                        </div>
                                    </div>
                            </div>
                            <!-- /.tab-pane -->
                        </div>
                        <!-- /.tab-content -->
                    </div><!-- /.card-body -->

                    <div class="card-footer">
                        <a class="btn btn-secondary float-left go-back" href="#" role="button">Cancel</a>
                        <button type="submit" class="btn btn-success float-right"><i class="fas fa-save"></i> Update Changes</button>
                    </div>

                    </form>

                </div>
                <!-- /.nav-tabs-custom -->
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </div><!-- /.container-fluid -->
</section>


<!-- Cropping modal -->
<div id="crop-avatar">
    <div class="modal fade" id="avatar-modal" aria-hidden="true" aria-labelledby="avatar-modal-label" role="dialog" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content panel-primary">
                <form class="avatar-form" action="<?= base_url(); ?>billconfig/upload" enctype="multipart/form-data" method="post">
                    <div class="modal-header panel-heading">
                        <h4 class="modal-title">Change Logo</h4>
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
                                <input type="hidden" id="user_sid" class="uss-id" name="user_sid" value="<?= $data['bill_config_id'] ?>">
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
<script src="<?= base_url('assets-' . app_version() . '/') ?>dist/js/scripts.js" type="module"></script>
<script src="<?= base_url('assets-' . app_version() . '/') ?>plugins/crop/js/main-logo.js" type="module"></script>
<script>
    $(function() {
        $('#bill_config_wbp_start_time').daterangepicker({
            timePicker: true,
            singleDatePicker: true,
            timePicker24Hour: true,
            timePickerIncrement: 1,
            timePickerSeconds: true,
            locale: {
                format: 'HH:mm:ss'
            }
        }).on('show.daterangepicker', function(ev, picker) {
            picker.container.find(".calendar-table").hide();
        });

        $('#bill_config_wbp_end_time').daterangepicker({
            timePicker: true,
            singleDatePicker: true,
            timePicker24Hour: true,
            timePickerIncrement: 1,
            timePickerSeconds: true,
            locale: {
                format: 'HH:mm:ss'
            }
        }).on('show.daterangepicker', function(ev, picker) {
            picker.container.find(".calendar-table").hide();
        });
    })
</script>