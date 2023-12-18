<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <!-- left column -->
            <div class="col-md">
                <!-- general form elements -->
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title"><button class="btn btn-link btn-sm go-back text-white" title="Go Back" data-toggle="tooltip" data-placement="right"><i class="cil-arrow-left mr-1 font-weight-bold"></i></button> Create New User</h3>
                    </div>
                    <!-- User Field -->
                    <form role="form" method="post" action="<?= base_url('user/add') ?>" autocomplete="off">
                        <div class="card-body">

                            <div class="row">

                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="exampleInputNoInduk">No Induk</label>
                                        <input type="text"
                                               class="form-control"
                                               autocapitalize="characters"
                                               autocomplete="off"
                                               name="no_induk" id="exampleInputNoInduk"
                                               value="<?= set_value('no_induk') ?>">
                                        <?= form_error('no_induk', '<small class="text-danger">', '</small>') ?>
                                    </div>

                                    <div class="form-group">
                                        <label for="exampleInputName">User Full Name</label>
                                        <input type="text"
                                               name="nama"
                                               autocapitalize="on"
                                               class="form-control" id="exampleInputName"
                                               value="<?= set_value('nama') ?>">
                                        <?= form_error('nama', '<small class="text-danger">', '</small>') ?>
                                    </div>

                                    <div class="form-group">
                                        <label for="exampleInputPhone">No Handphone</label>
                                        <input type="number"
                                               name="hp"
                                               autocapitalize="on"
                                               class="form-control" id="exampleInputPhone"
                                               value="<?= set_value('hp') ?>">
                                        <?= form_error('hp', '<small class="text-danger">', '</small>') ?>
                                    </div>

                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Email Address</label>
                                        <input type="email"
                                               name="email"
                                               class="form-control"
                                               id="exampleInputEmail1"
                                               value="<?= set_value('Mail') ?>">
                                        <?= form_error('Mail', '<small class="text-danger">', '</small>') ?>
                                    </div>

                                    <div class="form-group">
                                        <label>User Unit</label>
                                        <select value="<?= set_value('unit') ?>" class="form-control select2" name="unit" id="unit"
                                                style="width: 100% !important;">
                                            <option selected disabled></option>
                                            <?php foreach ($unit_region as $region) : ?>
                                                <?php if (intval($region['ref_value']) == 2 && $this->session->userdata('user_login_name') != '00000') : ?>
                                                    <option disabled value="<?= $region['ref_sid'] ?>"><?= $region['parent_name'] ?>
                                                        » <?= $region['ref_name'] ?></option>
                                                <?php else: ?>
                                                    <option value="<?= $region['ref_sid'] ?>"><?= $region['parent_name'] ?>
                                                        » <?= $region['ref_name'] ?></option>
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
                                        <select value="<?= set_value('hak') ?>" name="hak[]"
                                                class="form-control select-role select2" style="width: 100% !important;">
                                            <option selected disabled></option>
                                            <?php foreach ($user_roles as $item) : ?>
                                                <?php if ($item['ref_value'] == 0) : ?>
                                                    <option value="<?= $item['ref_sid'] ?>" disabled>
                                                        <?= role_level_indicator($item['ref_value'], $item['ref_description']); ?>
                                                        <?= $item['ref_name'] ?>
                                                    </option>
                                                <?php else : ?>
                                                    <option value="<?= $item['ref_sid'] ?>">
                                                        <?= role_level_indicator($item['ref_value'], $item['ref_description']); ?>
                                                        <?= $item['ref_name'] ?>
                                                    </option>
                                                <?php endif; ?>
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
                                                               value="1" checked>
                                                        Active </label>
                                                </div>
                                            </div>
                                            <div class="col-sm-5">
                                                <div class="form-radio">
                                                    <label class="form-check-label">
                                                        <input type="radio" class="form-check-input" name="active" id="is_active_0"
                                                               value="0"> Inactive
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="inputUserName" class="col-sm-4 control-label">User Name</label>
                                        <input autocomplete="off"
                                               value="<?= set_value('user_login_name') ?>" name="user_login_name" type="text"
                                               style="text-transform: unset !important;"
                                               class="form-control" id="inputUserName">
                                        <?= form_error('user_login_name', '<small class="text-danger">', '</small>') ?>
                                    </div>

                                    <div class="form-group">
                                        <label for="inputPasswordUser" class="col-sm-4 control-label">Password</label>
                                        <input autocomplete="off" type="password" name="password1" class="form-control"
                                               id="inputPasswordUser">
                                        <?= form_error('password1', '<small class="text-danger">', '</small>') ?>
                                    </div>

                                    <div class="form-group">
                                        <label for="inputPasswordUser" class="control-label">Konfirmasi Password</label>
                                        <input name="password2" type="password" class="form-control" id="inputPasswordUser">
                                        <?= form_error('password2', '<small class="text-danger">', '</small>') ?>
                                    </div>
                                </div>

                            </div>

                        </div>
                        <!-- /.card-body -->
                        <div class="card-footer">
                            <a class="btn btn-secondary float-left" href="<?= base_url('user') ?>" role="button">Cancel</a>
                            <button type="submit" class="btn btn-primary float-right"><i class="fas fa-save"></i> Save</button>
                        </div>
                    </form>
                </div>
                <!-- /.card -->
            </div>
            <!--/.col (left) -->
        </div>
        <!-- /.row -->
    </div>
</section>
<script src="<?= base_url('assets-' . app_version() . '/') ?>plugins/jquery/jquery.js"></script>
<script src="<?= base_url('assets-' . app_version() . '/') ?>dist/js/user.js" type="module"></script>
<script>
    $(document).ready(function () {
        setTimeout(function () {
            $("#inputUserName").val('');
            $("#inputPasswordUser").val('');
        }, 500);
    });
</script>
