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
                        <span class="card-title ml-2">Configuration Site Information</span>
                    </div>
                    <div class="card-body" style="padding-bottom: 20px !important;">
                        <div class="tab-content">
                            <!-- /.tab-pane -->
                            <div class="tab-pane active" id="settings">
                                <form role="form" method="post" action="<?= base_url('master/updateInfo') ?>" autocomplete="off">
                                    <input type="hidden" name="id" value="<?= $data['app_sid'] . set_value('app_sid'); ?>">

                                    <div class="row">

                                        <div class="col-lg-3">
                                            <!-- Profile Image -->
                                            <div class="card-no-shadow card-primary card-outline">
                                                <div class="card-body box-profile">
                                                    <div class="text-center">
                                                        <a href="#" class="text-center" data-toggle="tooltip" data-placement="bottom" title="Update Photo Profile">
                                                            <?php
                                                            $default = base_url('assets-' . app_version() . '/') . 'dist/img/no-image.png';
                                                            if ($this->session->userdata('profile_img') != null) {
                                                                $default = 'data:image/jpeg;base64,' . $this->session->userdata('profile_img');
                                                            }
                                                            ?>
                                                            <img class="profile-user-img img-fluid img-circle" src="<?= $default ?>" data-toggle="modal" data-target="#avatar-modal" id="render-avatar" class="circular-fix has-shadow border marg-top10" data-ussuid="<?php print base64_encode(1); ?>" data-backdrop="static" data-keyboard="false" data-upltype="avatar">
                                                        </a>
                                                    </div>

                                                    <h3 class="profile-username text-center mt-3"><?= $data['app_name'] ?></h3>
                                                    <p class="text-center mt-1"><?= $data['app_desc'] ?></p>

                                                </div>
                                                <!-- /.card-body -->
                                            </div>
                                            <!-- /.card -->
                                        </div>

                                        <div class="col-lg-9">

                                            <div class="row">
                                                <div class="col-lg-6">
                                                    <div class="form-group">
                                                        <label for="app_name">Application Name</label>
                                                        <input type="text" class="form-control" autocapitalize="off" autocomplete="off" name="app_name" id="app_name" value="<?= $data['app_name'] . set_value('app_name'); ?>">
                                                        <?= form_error('app_name', '<small class="text-danger">', '</small>') ?>
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="exampleInputName">Alt Name</label>
                                                        <input type="text" name="app_name_alt" autocapitalize="off" class="form-control" id="app_name_alt" value="<?= $data['app_name_alt'] . set_value('app_name_alt'); ?>">
                                                        <?= form_error('app_name_alt', '<small class="text-danger">', '</small>') ?>
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="app_first_name">First Name</label>
                                                        <input type="text" name="app_first_name" autocapitalize="off" class="form-control" id="app_first_name" value="<?= $data['app_first_name'] . set_value('app_first_name'); ?>">
                                                        <?= form_error('app_first_name', '<small class="text-danger">', '</small>') ?>
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="app_last_name">Last Name</label>
                                                        <input type="text" name="app_last_name" class="form-control" id="app_last_name" value="<?= $data['app_last_name'] . set_value('app_last_name'); ?>">
                                                        <?= form_error('app_last_name', '<small class="text-danger">', '</small>') ?>
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="app_desc">Description</label>
                                                        <textarea type="app_desc" name="app_desc" class="form-control" id="app_desc"><?= $data['app_desc'] . set_value('app_desc'); ?>
                                                </textarea>
                                                        <?= form_error('app_desc', '<small class="text-danger">', '</small>') ?>
                                                    </div>

                                                </div>
                                                <!--close row 1-->

                                                <div class="col-lg-6">

                                                    <div class="form-group">
                                                        <label for="phone">Phone Number</label>
                                                        <input type="number" name="phone" autocapitalize="on" class="form-control" id="phone" value="<?= $data['phone'] . set_value('phone'); ?>">
                                                        <?= form_error('phone', '<small class="text-danger">', '</small>') ?>
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="email">Email address</label>
                                                        <input type="email" name="email" class="form-control" id="email" value="<?= $data['email'] . set_value('email'); ?>">
                                                        <?= form_error('email', '<small class="text-danger">', '</small>') ?>
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="address">Site address</label>
                                                        <textarea type="address" name="address" class="form-control" id="address"><?= $data['address'] . set_value('address'); ?>
                                                </textarea>
                                                        <?= form_error('address', '<small class="text-danger">', '</small>') ?>
                                                    </div>

                                                </div>
                                            </div>

                                        </div>

                                    </div>
                                </form>
                            </div>
                            <!-- /.tab-pane -->
                        </div>
                        <!-- /.tab-content -->
                    </div><!-- /.card-body -->

                    <div class="card-footer">
                        <a class="btn btn-secondary float-left go-back" href="#" role="button">Cancel</a>
                        <button type="submit" class="btn btn-success float-right"><i class="fas fa-save"></i> Update Changes</button>
                    </div>

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
                <form class="avatar-form" action="<?= base_url(); ?>master/uploadIcon" enctype="multipart/form-data" method="post">
                    <div class="modal-header panel-heading">
                        <h4 class="modal-title">Change Photo Profile</h4>
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
                                <input type="hidden" id="user_sid" class="uss-id" name="user_sid" value="<?= $data['app_sid'] ?>">
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
<script src="<?= base_url('assets-' . app_version() . '/') ?>plugins/crop/js/main.js" type="module"></script>