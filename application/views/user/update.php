<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <!-- left column -->
            <div class="col-lg-12">
                <!-- general form elements -->
                <div class="card card-success">
                    <div class="card-header">
                        <h3 class="card-title"><button class="btn btn-link btn-sm go-back text-white" title="Go Back" data-toggle="tooltip" data-placement="right"><i class="cil-arrow-left mr-1 font-weight-bold"></i></button> Update User</h3>
                    </div>
                    <!-- User Field -->
                    <form role="form" method="post" action="<?= base_url('user/update') ?>" autocomplete="off">
                        <div class="card-body">

                            <div class="row">
                                <div class="col-lg-3">
                                    <div class="card-no-shadow card-secondary card-outline">
                                        <div class="card-body box-profile">
                                            <center>
                                                <img class="profile-user-img img-fluid img-circle images-profile" src="<?= base_url('assets-' . app_version() . '/') . 'dist/img/loading-2.gif' ?>" data-id="<?= $user['user_sid'] ?>" class="circular-fix has-shadow border marg-top10" data-ussuid="<?php print base64_encode(1); ?>" data-backdrop="static" data-keyboard="false" data-upltype="avatar">
                                            </center>
                                        </div>
                                        <!-- /.card-body -->
                                    </div>

                                    <div class="card-no-shadow card-secondary card-outline mt-3">
                                        <span class="p-2"><i class="fas fa-info-circle"></i> User Record</span>
                                        <table class="table table-sm table-striped mb-2">
                                            <tr>
                                                <td><small>User UUID</small></td>
                                                <td><small><?= $user['user_sid'] ?></small></td>
                                            </tr>
                                            <tr>
                                                <td><small>Last Sync</small></td>
                                                <td><small><?= $user['last_connect'] ?></small></td>
                                            </tr>
                                            <tr>
                                                <td><small>Last Login</small></td>
                                                <td><small><?= $user['last_login'] ?></small></td>
                                            </tr>
                                            <tr>
                                                <td><small>Login Coordinates</small></td>
                                                <td><small><a target="_blank" data-toggle="tooltip" title="View on google map" class="openMap text-primary" href="https://www.google.com/maps?q=<?= $user['lon_login'] ?>, <?= $user['lat_login'] ?>">
                                                            <small><i class="fas fa-map-marker-alt"></i></small>&nbsp; <?= $user['lon_login'] ?>, <?= $user['lat_login'] ?></a>
                                                    </small></td>
                                            </tr>
                                            <tr>
                                                <td><small>Last update</small></td>
                                                <td><small>
                                                        <?php
                                                        $json_info = json_decode($user['device_info'], true);
                                                        $info = "Brand/Model : " . $json_info['brand'] . " " . $json_info['model'] . "<br>OS Version : " . $json_info['release'] . "<br>App Version : " . $json_info['version_app'];
                                                        echo $info;
                                                        ?>
                                                    </small></td>
                                            </tr>
                                            <tr>
                                                <td><small>Last Update</small></td>
                                                <td><small> <?= $user['date_modified'] ?></small></td>
                                            </tr>
                                        </table>
                                    </div>

                                </div>
                                <div class="col-lg-9">
                                    <input type="hidden" name="id" value="<?= $user['user_sid'] . set_value('user_sid'); ?>">

                                    <div class="row">

                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label for="exampleInputNoInduk">No Induk</label>
                                                <input type="text" class="form-control" autocapitalize="characters" autocomplete="off" name="no_induk" id="no_induk" value="<?= $user['user_no_induk'] . set_value('no_induk'); ?>">
                                                <?= form_error('no_induk', '<small class="text-danger">', '</small>') ?>
                                            </div>

                                            <div class="form-group">
                                                <label for="exampleInputName">User Full Name</label>
                                                <input type="text" name="nama" autocapitalize="on" class="form-control" id="nama" value="<?= $user['user_name'] . set_value('nama'); ?>">
                                                <?= form_error('nama', '<small class="text-danger">', '</small>') ?>
                                            </div>

                                            <div class="form-group">
                                                <label for="exampleInputPhone">No Handphone</label>
                                                <input type="number" name="hp" autocapitalize="on" class="form-control" id="hp" value="<?= $user['user_phone'] . set_value('hp'); ?>">
                                                <?= form_error('hp', '<small class="text-danger">', '</small>') ?>
                                            </div>

                                            <div class="form-group">
                                                <label for="exampleInputEmail1">Email Address</label>
                                                <input type="email" name="email" class="form-control" id="email" value="<?= $user['user_email'] . set_value('email'); ?>">
                                                <?= form_error('Mail', '<small class="text-danger">', '</small>') ?>
                                            </div>

                                            <!-- select -->
                                            <div class="form-group">
                                                <label>User Unit</label>
                                                <select value="<?= set_value('unit') ?>" class="form-control select2" name="unit" id="unit" style="width: 100%;">
                                                    <option selected disabled>Select..</option>
                                                    <?php foreach ($unit_region as $item) : ?>
                                                        <?php if (intval($item['ref_value']) == 2 && $this->session->userdata('user_login_name') != '00000') : ?>
                                                            <option disabled <?php if ($user['user_unit'] == $item['ref_sid']) echo 'selected' ?> value="<?= $item['ref_sid'] ?>">
                                                                <?= $item['parent_name'] ?> » <?= $item['ref_name'] ?>
                                                            </option>
                                                        <?php else : ?>
                                                            <option <?php if ($user['user_unit'] == $item['ref_sid']) echo 'selected' ?> value="<?= $item['ref_sid'] ?>">
                                                                <?= $item['parent_name'] ?> » <?= $item['ref_name'] ?>
                                                            </option>
                                                        <?php endif; ?>

                                                    <?php endforeach; ?>
                                                </select>
                                                <?= form_error('unit', '<small class="text-danger">', '</small>') ?>
                                            </div>
                                        </div>

                                        <div class="col-lg-6">
                                            <!-- select -->
                                            <div class="form-group">
                                                <label>User Role</label>
                                                <select value="<?= set_value('hak') ?>" name="hak[]" class="form-control select-role-update select2" style="width: 100%;">
                                                    <option disabled>Select..</option>
                                                    <?php foreach ($user_roles as $item) : ?>
                                                        <option <?php
                                                                foreach ($user_role as $role) {
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
                                                                <input type="radio" class="form-check-input" name="active" id="is_active_1" value="1" <?php if (intval($user['is_active']) == 1) echo 'checked' ?>>
                                                                Active
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-5">
                                                        <div class="form-radio">
                                                            <label class="form-check-label">
                                                                <input type="radio" class="form-check-input" name="active" id="is_active_0" value="0" <?php if (intval($user['is_active']) == 0) echo 'checked' ?>>
                                                                Inactive
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="mt-2">User Name</label>
                                                <input autocomplete="off" value="<?= $user['user_login_name'] . set_value('user_login_name'); ?>" name="user_login_name" type="text" style="text-transform: unset !important;" class="form-control" id="inputUserName">
                                                <?= form_error('user_login_name', '<small class="text-danger">', '</small>') ?>
                                            </div>

                                            <div class="form-group">
                                                <label>Password</label>
                                                <input autocomplete="off" type="password" name="password1" class="form-control" id="inputPasswordUser">
                                                <?= form_error('password1', '<small class="text-danger">', '</small>') ?>
                                            </div>

                                            <div class="form-group">
                                                <label>Konfirmasi Password</label>
                                                <input name="password2" type="password" class="form-control" id="inputPasswordUser2">
                                                <?= form_error('password2', '<small class="text-danger">', '</small>') ?>
                                            </div>

                                            <a class="mt-3 mr-2 btn btn-secondary float-left" href="<?= base_url('user') ?>" role="button">Cancel</a>
                                            <button type="submit" class="btn btn-success mt-3"><i class="fas fa-save"></i> Update Changes</button>


                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
<script src="<?= base_url('assets-' . app_version() . '/') ?>plugins/jquery/jquery.js"></script>
<script src="<?= base_url('assets-' . app_version() . '/') ?>dist/js/user.js" type="module"></script>
<script>
    $(document).ready(function() {
        setTimeout(function() {
            $("#inputPasswordUser").val('');
            $("#inputPasswordUser").attr('placeholder', 'Ketik untuk merubah (biarkan blank jika password tidak ingin diupdate)');
            $("#inputPasswordUser2").attr('placeholder', 'Konfirmasi perubahan password');
        }, 500);
    });
</script>