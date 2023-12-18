<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-3">
                <!-- Profile Image -->
                <div class="card card-primary card-outline">
                    <div class="card-body box-profile">
                        <center>
                            <a href="#" class="text-center" data-toggle="tooltip" data-placement="bottom" title="Update Photo Profile">
                                <?php
                                $default = base_url('assets-'.app_version().'/') . 'dist/img/user-profile-default.jpg';
                                if ($this->session->userdata('profile_img') != null) {
                                    $default = 'data:image/jpeg;base64,' . $this->session->userdata('profile_img');
                                }
                                ?>
                                <img class="profile-user-img img-fluid img-circle"
                                     src="<?= $default ?>"
                                     data-toggle="modal" data-target="#avatar-modal" id="render-avatar" class="circular-fix has-shadow border marg-top10" data-ussuid="<?php print base64_encode(1);?>" data-backdrop="static" data-keyboard="false" data-upltype="avatar">
                            </a>
                        </center>

                        <h3 class="profile-username text-center mt-3"><?= $user['user_name'] ?></h3>

                        <?php foreach ($user_roles as $role) : ?>
                            <p class="text-muted text-center"><?= $role['ref_name'] ?></p>
                        <?php endforeach; ?>

                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->

                <!-- About Me Box -->
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">User Info</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <strong><i class="fas fa-id-badge mr-1"></i> Nomor Induk </strong>

                        <p class="text-muted">
                            <?= $user['user_no_induk'] ?>
                        </p>

                        <hr>

                        <strong><i class="fas fa-phone-square-alt mr-1"></i> No Handphone</strong>

                        <p class="text-muted"><?= $user['user_phone'] ?></p>

                        <hr>

                        <strong><i class="fas fa-envelope mr-1"></i> Email Address</strong>

                        <p class="text-muted"><?= $user['user_email'] ?></p>

                    </div>
                    <!-- /.card-body -->
                </div>
                <div class="card card-dark">
                    <div class="card-header">
                        <h3 class="card-title">Additional Info</h3>
                    </div>
                    <div class="card-body">
                        <table class="table table-sm">
                            <tr>
                                <td>
                                    <small>User UUID</small>
                                </td>
                                <td>
                                    <small class="text-break"><?= $user['user_sid'] ?></small>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <small>Last Sync</small>
                                </td>
                                <td>
                                    <small class="text-break"><?= $user['last_connect'] ?></small>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <small>Last Login</small>
                                </td>
                                <td>
                                    <small class="text-break"><?= $user['last_login'] ?></small>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <small>Login Coordinates</small>
                                </td>
                                <td>
                                    <small class="text-break">
                                        <a target="_blank" data-toggle="tooltip" title="View on google map" class="openMap text-primary"
                                              href="https://www.google.com/maps?q=<?= $user['lat_login'] ?>, <?= $user['lon_login'] ?>">
                                            <small><i class="fas fa-map-marker-alt"></i></small>&nbsp; <?= $user['lat_login'] ?>
                                            , <?= $user['lon_login'] ?></a>
                                    </small>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <small>Device Info</small>
                                </td>
                                <td>
                                    <small class="text-break">
                                        <?php
                                        $json_info = json_decode($user['device_info'], true);
                                        $info = "Brand/Model : " . $json_info['brand'] . " " . $json_info['model'] . "<br>OS Version : " . $json_info['release'] . "<br>App Version : " . $json_info['version_app'];
                                        echo $info;
                                        ?>
                                    </small>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
                <!-- /.card -->
            </div>
            <!-- /.col -->
            <div class="col-md-9">
                <div class="card">
                    <div class="card-header p-2">
                        <ul class="nav nav-pills">
                            <li class="nav-item"><a class="nav-link active" href="#settings" data-toggle="tab">Update Profile <i
                                            class="fas fa-edit ml-1"></i></a></li>
                        </ul>
                    </div><!-- /.card-header -->
                    <div class="card-body pb-4" style="padding-bottom: 40px !important;">
                        <div class="tab-content">
                            <!-- /.tab-pane -->
                            <div class="tab-pane active" id="settings">
                                <form role="form" method="post" action="<?= base_url('user/profile') ?>" autocomplete="off">
                                    <input type="hidden"
                                           name="id"
                                           value="<?= $user['user_sid'] . set_value('user_sid'); ?>">
                                    <input type="hidden"
                                           name="no_induk"
                                           value="<?= $user['user_no_induk'] . set_value('user_no_induk'); ?>">
                                    <input type="hidden"
                                           name="unit"
                                           value="<?= $user['user_unit'] . set_value('unit'); ?>">

                                    <div class="row">

                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label for="exampleInputNoInduk">No Induk</label>
                                                <input type="text" disabled
                                                       class="form-control"
                                                       autocapitalize="characters"
                                                       autocomplete="off"
                                                       name="no_induk" id="no_induk"
                                                       value="<?= $user['user_no_induk'] ?>">
                                                <?= form_error('no_induk', '<small class="text-danger">', '</small>') ?>
                                            </div>

                                            <div class="form-group">
                                                <label for="exampleInputName">Name</label>
                                                <input type="text"
                                                       name="nama"
                                                       autocapitalize="on"
                                                       class="form-control" id="nama"
                                                       value="<?= $user['user_name'] . set_value('user_name'); ?>">
                                                <?= form_error('nama', '<small class="text-danger">', '</small>') ?>
                                            </div>

                                            <div class="form-group">
                                                <label for="exampleInputPhone">No Handphone</label>
                                                <input type="number"
                                                       name="hp"
                                                       autocapitalize="on"
                                                       class="form-control" id="hp"
                                                       value="<?= $user['user_phone'] ?>">
                                                <?= form_error('hp', '<small class="text-danger">', '</small>') ?>
                                            </div>

                                            <div class="form-group">
                                                <label for="exampleInputEmail1">Email address</label>
                                                <input type="email"
                                                       name="email"
                                                       class="form-control"
                                                       id="email"
                                                       value="<?= $user['user_email'] ?>">
                                                <?= form_error('Mail', '<small class="text-danger">', '</small>') ?>
                                            </div>

                                            <div class="form-group">
                                                <label>Sebutan Jabatan</label>
                                                <select value="<?= set_value('jabatan') ?>" name="jabatan" class="form-control select2"
                                                        style="width: 100%;">
                                                    <option selected="selected" disabled>Select..</option>
                                                    <?php foreach ($jabatan as $item) : ?>
                                                        <option
                                                                value="<?= $item['ref_sid'] ?>"
                                                            <?php if ($user['user_jabatan'] == $item['ref_sid']) echo 'selected' ?>>
                                                            <?= $item['ref_name'] ?>
                                                        </option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>

                                            <div class="form-group">
                                                <label>Bagian</label>
                                                <select value="<?= set_value('bagian') ?>" name="bagian" class="form-control select2"
                                                        style="width: 100%;">
                                                    <option selected="selected" disabled>Select..</option>
                                                    <?php foreach ($bagian as $item) : ?>
                                                        <option <?php if ($user['user_bagian'] == $item['ref_sid']) echo 'selected' ?>
                                                                value="<?= $item['ref_sid'] ?>"><?= $item['ref_name'] ?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                                <?= form_error('bagian', '<small class="text-danger">', '</small>') ?>
                                            </div>

                                        </div>

                                        <div class="col-lg-6">
                                            <!-- select -->
                                            <div class="form-group">
                                                <label>Unit Region</label>
                                                <select disabled value="<?= set_value('unit') ?>" class="form-control select2" name="unit" id="unit"
                                                        style="width: 100%;">
                                                    <option selected disabled>Select..</option>
                                                    <?php foreach ($ulp as $item) : ?>
                                                        <?php if (intval($item['ref_value']) == 2 && $this->session->userdata('user_login_name') != '00000') : ?>
                                                            <option disabled <?php if ($user['user_unit'] == $item['ref_sid']) echo 'selected' ?>
                                                                    value="<?= $item['ref_sid'] ?>">
                                                                <?= $item['parent_name'] ?> » <?= $item['ref_name'] ?>
                                                            </option>
                                                        <?php else: ?>
                                                            <option <?php if ($user['user_unit'] == $item['ref_sid']) echo 'selected' ?>
                                                                    value="<?= $item['ref_sid'] ?>">
                                                                <?= $item['parent_name'] ?> » <?= $item['ref_name'] ?>
                                                            </option>
                                                        <?php endif; ?>

                                                    <?php endforeach; ?>
                                                </select>
                                                <?= form_error('unit', '<small class="text-danger">', '</small>') ?>
                                            </div>

                                            <!-- select -->
                                            <div class="form-group">
                                                <label>User Role</label>
                                                <select disabled multiple="true" value="<?= set_value('hak') ?>" name="hak[]"
                                                        class="form-control select-role-update select2" style="width: 100%;">
                                                    <option disabled>Select..</option>
                                                    <?php foreach ($hak_user as $item) : ?>
                                                        <option
                                                            <?php
                                                            foreach ($user_roles as $role) {
                                                                if ($role['ur_role_sid'] == $item['ref_sid']) {
                                                                    echo 'selected';
                                                                }
                                                            }
                                                            ?> value="<?= $item['ref_sid'] ?>">
                                                            <?= role_level_indicator($item['ref_value'], $item['ref_description']); ?>
                                                            <?= $item['ref_name'] ?>
                                                        </option>
                                                    <?php endforeach; ?>
                                                </select>
                                                <?= form_error('hak', '<small class="text-danger">', '</small>') ?>
                                            </div>

                                            <div class="form-group">
                                                <label>User Activation</label>
                                                <div class="row ml-3">
                                                    <div class="col-sm-4">
                                                        <div class="form-radio">
                                                            <label class="form-check-label">
                                                                <input type="radio" class="form-check-input" name="active" id="is_active_1"
                                                                       value="1"
                                                                    <?php if (intval($user['is_active']) == 1) echo 'checked' ?>
                                                                >
                                                                Active
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-5">
                                                        <div class="form-radio">
                                                            <label class="form-check-label">
                                                                <input type="radio" class="form-check-input" name="active" id="is_active_0"
                                                                       value="0"
                                                                    <?php if (intval($user['is_active']) == 0) echo 'checked' ?>
                                                                >
                                                                Inactive
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label>User Name</label>
                                                <input autocomplete="off"
                                                       value="<?= $user['user_login_name'] . set_value('user_login_name'); ?>"
                                                       name="user_login_name" type="text" style="text-transform: unset !important;"
                                                       class="form-control" id="inputUserName">
                                                <?= form_error('user_login_name', '<small class="text-danger">', '</small>') ?>
                                            </div>

                                            <div class="form-group">
                                                <label>Password</label>
                                                <input autocomplete="off" type="password" name="password1" class="form-control"
                                                       id="inputPasswordUser">
                                                <?= form_error('password1', '<small class="text-danger">', '</small>') ?>
                                            </div>

                                            <div class="form-group">
                                                <label>Konfirmasi Password</label>
                                                <input name="password2" type="password" class="form-control" id="inputPasswordUser">
                                                <?= form_error('password2', '<small class="text-danger">', '</small>') ?>
                                            </div>
                                        </div>

                                    </div>

                                    <button type="submit" class="btn btn-success mt-2"><i class="fas fa-save"></i> Update Changes</button>

                                </form>
                            </div>
                            <!-- /.tab-pane -->
                        </div>
                        <!-- /.tab-content -->
                    </div><!-- /.card-body -->
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
                <form class="avatar-form" action="<?= base_url(); ?>user/upload" enctype="multipart/form-data" method="post">
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
                                <input type="hidden" id="user_sid" class="uss-id" name="user_sid" value="<?= $user['user_sid'] ?>">
                                <input type="hidden" class="avatar-src" name="avatar_src">
                                <input type="hidden" class="avatar-data" name="avatar_data">
                            </div>
                        </div>

                    </div>
                    <div class="modal-footer panel-footer">
                        <button type="button" class="avatar-btns btn btn-light" data-method="rotate" data-option="-90" title="Rotate the image 9 degree to the left"><i class="fas fa-undo"></i> Rotate</button>


                        <button type="button" class="avatar-btns btn btn-light" data-method="rotate" data-option="-90" title="Rotate the image 9 degree to the right"><i class="fas fa-redo"></i> Rotate</button>
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

<script src="<?= base_url('assets-'.app_version().'/') ?>plugins/jquery/jquery-3.3.1.js"></script>
<script src="<?= base_url('assets-'.app_version().'/') ?>plugins/crop/js/cropper.js"></script>
<script src="<?= base_url('assets-'.app_version().'/') ?>dist/js/scripts.js" type="module"></script>
<script src="<?= base_url('assets-'.app_version().'/') ?>plugins/crop/js/main.js" type="module"></script>