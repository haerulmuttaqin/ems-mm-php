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

                        <div class="card-body text-center">

                            <img class="mb-3" src="<?php echo base_url() . 'assets-' . app_version() . '/dist/img/undraw_bugsvg.svg'?>" width="200px">

                            <div class="error-content mt-4">
                                <h2><i class="fas fa-exclamation-circle text-danger"></i> 403 Access Forbidden.</h2>
                                <br>

                                <p>
                                    <h4>The server understood the request!, but is refusing to fulfill it. </h4>
                                    Dukungan peramban (browser) belum di dukung..
                                </p>

                                <br>
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