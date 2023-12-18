<script src="<?= base_url('assets-'.app_version().'/') ?>plugins/jquery/jquery.min.js"></script>
<script src="<?= base_url('assets-'.app_version().'/') ?>plugins/toastr/toastr.min.js"></script>
<link rel="stylesheet" href="<?= base_url('assets-'.app_version().'/') ?>plugins/toastr/toastr.css">


<script type="text/javascript">

    toastr.options = {
        "closeButton": true,
        "debug": false,
        "newestOnTop": false,
        "progressBar": false,
        "positionClass": "toast-bottom-right",
        "preventDuplicates": false,
        "onclick": null,
        "showDuration": "70",
        "hideDuration": "100",
        "timeOut": "7000",
        "extendedTimeOut": "1000",
        "showEasing": "swing",
        "hideEasing": "linear",
        "showMethod": "fadeIn",
        "hideMethod": "fadeOut"
    };

    <?php if ($this->session->flashdata('success')) {?>
    toastr.success("<?php echo $this->session->flashdata('success'); ?>");
    <?php } else if ($this->session->flashdata('error')) {?>
    toastr.error("<?php echo $this->session->flashdata('error'); ?>");
    <?php } else if ($this->session->flashdata('warning')) {?>
    toastr.warning("<?php echo $this->session->flashdata('warning'); ?>");
    <?php } else if ($this->session->flashdata('info')) {?>
    toastr.info("<?php echo $this->session->flashdata('info'); ?>");
    <?php }?>


</script>