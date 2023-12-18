<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>SMOKOL - 403</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="<?= base_url('assets-'.app_version().'/') ?>plugins/fontawesome-free/css/all.min.css" crossorigin="anonymous">
    <!-- icheck bootstrap -->
    <link rel="stylesheet" href="<?= base_url('assets-'.app_version().'/') ?>plugins/icheck-bootstrap/icheck-bootstrap.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="<?= base_url('assets-'.app_version().'/') ?>dist/css/adminlte.min.css">
    <!-- Google Font: Source Sans Pro -->
    <link rel="shortcut icon" href="<?= base_url('assets-'.app_version().'/') ?>dist/img/icon.png" />

</head>
<body class="hold-transition login-page">
<section class="content">
    <div class="content">
        <div class="container-fluid">
            <div class="row mt-lg-4">
                <br><br>
                <div class="col-lg-5 ml-auto mr-auto">

                    <div class="card card-danger card-outline">

                        <div class="card-body">

                            <div class="error-content">
                                <h3><i class="fas fa-exclamation-circle text-danger"></i> 403 Access Forbidden.</h3>
                                <br>

                                <p>
                                    Akses dibatasi! <br>
                                    It looks like you found a glitch in the matrix.. (Access Denied) <a href="<?= base_url('auth') ?>">turn back now!</a> or contact the administrator
                                </p>

                                <br>

                                <button class="btn btn-outline-primary " onclick="window.history.back()"><i class="fas fa-long-arrow-alt-left mr-2"></i> Back</button>

                            </div>

                        </div>

                    </div>

                </div>
            </div>
        </div>
    </div>
</section>
</body>
</html>