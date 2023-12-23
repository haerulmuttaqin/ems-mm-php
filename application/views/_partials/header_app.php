<!DOCTYPE html>
<!--
Developed by Haerul Muttaqin - Nov 2020
-->
<html lang="id" style="height: 100%;">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="x-ua-compatible" content="ie=edge">

    <title><?= app_name_alt() ?> — <?= $title ?></title>
    <!-- Ionicons -->
    <link rel="stylesheet" href="<?= base_url('assets-' . app_version() . '/') ?>plugins/select2/css/select2.css">
    <link rel="stylesheet" href="<?= base_url('assets-' . app_version() . '/') ?>dist/css/adminlte.css">
    <link rel="stylesheet" href="<?= base_url('assets-' . app_version() . '/') ?>dist/css/style.css">
    <link rel="stylesheet" href="<?= base_url('assets-' . app_version() . '/') ?>dist/css/iaspp.css">
    <link rel="stylesheet" href="<?= base_url('assets-' . app_version() . '/') ?>dist/css/animate.css">
    <link rel="stylesheet" href="<?= base_url('assets-' . app_version() . '/') ?>plugins/fontawesome-free/css/all.min.css">
    <link rel="stylesheet" href="<?= base_url('assets-' . app_version() . '/') ?>plugins/coreui-icons/css/all.min.css">
    <link rel="stylesheet" href="<?= base_url('assets-' . app_version() . '/') ?>plugins/checkbox/pretty-checkbox.min.css">
    <link rel="stylesheet" href="<?= base_url('assets-' . app_version() . '/') ?>plugins/sweetalert2/sweetalert2.css">
    <link rel="stylesheet" href="<?= base_url('assets-' . app_version() . '/') ?>plugins/daterangepicker/daterangepicker.css">
    <link rel="stylesheet" href="<?= base_url('assets-' . app_version() . '/') ?>plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
    <link rel="stylesheet" href="<?= base_url('assets-' . app_version() . '/') ?>plugins/datatables/dataTables.bootstrap4.css">
    <link rel="stylesheet" href="<?= base_url('assets-' . app_version() . '/') ?>plugins/datatables/extensions/Mark/datatables.mark.min.css">
    <link rel="stylesheet" href="<?= base_url('assets-' . app_version() . '/') ?>plugins/datatables/extensions/FixedColumns/css/dataTables.fixedColumns.css">
    <link rel="stylesheet" href="<?= base_url('assets-' . app_version() . '/') ?>plugins/datatables/dataTables.checkboxes.css">
    <link rel="stylesheet" href="<?= base_url('assets-' . app_version() . '/') ?>plugins/crop/css/cropper.css">
    <link rel="stylesheet" href="<?= base_url('assets-' . app_version() . '/') ?>plugins/shimmer/shimmer.css">
    <link rel="stylesheet" href="<?= base_url('assets-' . app_version() . '/') ?>plugins/progress/pace.css">
    <link rel="stylesheet" href="<?= base_url('assets-' . app_version() . '/') ?>dist/css/bootstrap-iconpicker.css">
    <link rel="stylesheet" href="<?= base_url('assets-' . app_version() . '/') ?>plugins/view-bigimg/view-bigimg.css">
    <link rel="shortcut icon" href="<?= base_url('assets-' . app_version() . '/') ?>dist/img/favicon.png" />

</head>
<input type="hidden" id="unit" value="<?= $unit ?>">
<input type="hidden" id="user_data" value="<?= json_encode($user_data) ?>">
<body style="height: 100%;">
