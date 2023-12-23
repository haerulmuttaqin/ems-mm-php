<div>
    <?php
    $this->load->view('_partials/alert');
    ?>
</div>

<footer class="footer pl-2 pr-2">
    <!-- Default to the left -->
    <span
        class="text-sm float-left"> <?= strtoupper($unit); ?> Building, loggedin as : <?= $user_data['user_name'] ?> —
    <a href="<?= base_url('/home') ?>" class="href">home</a> | <a href="<?= base_url('/settings') ?>" class="href">settings</a> | <a href="<?= base_url('logout') ?>" class="href">log out</a>
    </span>
    <span
        class="text-sm float-right" id="time"> ... </span>
</footer>
<script type="text/javascript">
    let timestamp = '<?=time();?>';

    function updateTime() {
        $('#time').html(Date(timestamp));
        timestamp++;
    }

    $(function () {
        setInterval(updateTime, 1000);
    });
</script>
<script src="<?= base_url('assets-' . app_version() . '/') ?>plugins/jquery/jquery-3.3.1.js"></script>
<script data-pace-options='{ "ajax": false }'
        src="<?= base_url('assets-' . app_version() . '/') ?>plugins/progress/pace.min.js"></script>
<script src="<?= base_url('assets-' . app_version() . '/') ?>plugins/jquery-ui/jquery-ui.min.js"></script>
<script src="<?= base_url('assets-' . app_version() . '/') ?>plugins/popper/umd/popper.min.js"></script>
<script src="<?= base_url('assets-' . app_version() . '/') ?>plugins/bootstrap/js/bootstrap.bundle.js"></script>
<script src="<?= base_url('assets-' . app_version() . '/') ?>plugins/select2/js/select2.full.js"></script>
<script src="<?= base_url('assets-' . app_version() . '/') ?>plugins/view-bigimg/view-bigimg.js"></script>
<script
    src="<?= base_url('assets-' . app_version() . '/') ?>plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
<script src="<?= base_url('assets-' . app_version() . '/') ?>plugins/moment/moment.min.js"></script>
<script src="<?= base_url('assets-' . app_version() . '/') ?>plugins/daterangepicker/daterangepicker.js"></script>
<script src="<?= base_url('assets-' . app_version() . '/') ?>plugins/icheck/icheck.js"></script>
<script src="<?= base_url('assets-' . app_version() . '/') ?>plugins/sweetalert2/sweetalert2.min.js"></script>
<script src="<?= base_url('assets-' . app_version() . '/') ?>plugins/chart.js/Chart.min.js"></script>
<script src="<?= base_url('assets-' . app_version() . '/') ?>plugins/crop/js/cropper.js"></script>
<script src="<?= base_url('assets-' . app_version() . '/') ?>plugins/push.js/bin/push.js"></script>
<script src="<?= base_url('assets-' . app_version() . '/') ?>plugins/fastclick/fastclick.js"></script>
<script src="<?= base_url('assets-' . app_version() . '/') ?>dist/js/adminlte.min.js"></script>
<!--<script src="--><?php //= base_url('assets-' . app_version() . '/') ?><!--dist/js/bootstrap-iconpicker.bundle.min.js"></script>-->
<script src="<?= base_url('assets-' . app_version() . '/') ?>dist/js/main.js" type="module"></script>
<script src="<?= base_url('assets-' . app_version() . '/') ?>plugins/datatables/jquery.dataTables.js"></script>
<!--<script type="text/javascript" src="https://cdn.datatables.net/1.10.11/js/jquery.dataTables.js"></script>-->
<script src="<?= base_url('assets-' . app_version() . '/') ?>plugins/datatables/dataTables.bootstrap4.js"
        type="module"></script>
<script src="<?= base_url('assets-' . app_version() . '/') ?>plugins/datatables/dataTables.checkboxes.min.js"
        type="module"></script>
<script src="<?= base_url('assets-' . app_version() . '/') ?>plugins/datatables/extensions/Mark/mark.min.js"></script>
<script
    src="<?= base_url('assets-' . app_version() . '/') ?>plugins/datatables/extensions/Mark/datatables.mark.js"></script>
<script
    src="<?= base_url('assets-' . app_version() . '/') ?>plugins/datatables/extensions/FixedColumns/js/dataTables.fixedColumns.js"></script>
<script
    src="<?= base_url('assets-' . app_version() . '/') ?>plugins/datatables/extensions/FixedColumns/js/fixedColumns.bootstrap4.js"></script>
<script
    src="<?= base_url('assets-' . app_version() . '/') ?>plugins/datatables/extensions/FixedColumns/js/fixedColumns.bootstrap4.js"></script>
<script src="<?= base_url('assets-' . app_version() . '/') ?>plugins/parsley/parsley.js"></script>
<script src="<?= base_url('assets-' . app_version() . '/') ?>dist/js/scripts.js" type="module"></script>
</body>

</html>