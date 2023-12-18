<div class="context">
    <div class="login-box">
        <!-- /.login-logo -->
        <div class="login-logo" style="margin-left: 30px; margin-right: 30px">
            <a class="text-light" href="<?= base_url() ?>">
                <h3><i class="cil-bolt"></i>   MM</h3>
                <div class="font-weight-lighter text-light mt-4" style="font-size: 15px;">Login to system</div>
            </a>
        </div>
        <div class="card-extra-shadow mb-4">
            <div class="card-body">
                <div class="text-block text-center my-1 mb-4 mt-2">
                    <img class="mb-4 mt-2" src="<?= base_url() . 'assets-' . app_version() . '/dist/img/yk_logo.png' ?>" alt="" width="auto" height="70px">
                </div>
                <form autocomplete="off" action="<?= base_url('auth') ?>" method="post" class="mt-3">

                    <div class="input-group">
                        <input style="border-right:0;" autocomplete="false" required type="text" id="username" name="username" class="form-control <?= form_error('username', 'is-invalid ', '') ?>" placeholder="Username">
                        <div class="input-group-append input-group-text" style="border-top-left-radius: 0; border-bottom-left-radius: 0">
                            <i class="cil-user"></i>
                        </div>
                    </div>
                    <?= form_error('username', '<small class="text-danger">', '</small>') ?>

                    <div class="input-group mt-3">
                        <input style="border-right:0;" required type="password" id="password" name="password" class="form-control <?= form_error('password', 'is-invalid ', '') ?>" placeholder="Password">
                        <div class="input-group-append input-group-text" style="border-top-left-radius: 0; border-bottom-left-radius: 0">
                            <i class="cil-lock-locked"></i>
                        </div>
                    </div>
                    <?= form_error('password', '<small class="text-danger">', '</small>') ?>

                    <div class="row mt-3">
                        <div class="col-8">
                            <div class="icheck-primary">
                                <input type="checkbox" id="remember">
                                <label for="remember">
                                    Remember Me
                                </label>
                            </div>
                        </div>
                        <!-- /.col -->
                        <div class="col-4">
                            <button id="login" type="button" class="btn btn-success btn-block" disabled>....</button>
                        </div>
                        <!-- /.col -->
                        <div class="transaction-body loading-mask-round"></div>

                    </div>
                </form>
            </div>
            <!-- /.login-card-body -->
        </div>
        <!-- Default to the left -->
        <div class="text-center">
            <small class="text-light">App Version <?= app_version() ?> </small>
            <br>
            <small class="text-light">Copyright &copy; <?= date('Y', time()) . ' ' . app_name() ?> All rights reserved.</small>
        </div>
    </div>
</div>

<div class="area" >
    <ul class="circles">
        <li></li>
        <li></li>
        <li></li>
        <li></li>
        <li></li>
        <li></li>
        <li></li>
        <li></li>
        <li></li>
        <li></li>
        <li></li>
        <li></li>
        <li></li>
    </ul>
</div>