<!-- Main content -->
<section class="content">

    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card card-primary card-outline">
                        <div class="card-header">
                            <a href="<?= base_url('master#tab' . $client_menu[0]['category_sid']) ?>" tyle="margin-right: 5px;"
                               class="btn btn-primary"><i class="fas fa-plus-circle"></i> Add Client Menu
                            </a>
                        </div>
                        <div class="card-body">

                            <?= form_error('menu',
                                '<div class="alert alert-danger" role="alert">',
                                '<button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                                </button></div>')
                            ?>

                            <h5 class="mb-4">Change Menu Icon</h5>

                            <div class="row">
                                <?php $i = 1; ?>
                                <?php foreach ($client_menu as $m) : ?>
                                    <div class="col-lg-3 col-sm-6">
                                        <div class="card-no-shadow mb-3" >
                                            <div class="card-body box-profile" data-toggle="tooltip" data-placement="bottom"
                                                 title="Update Icon">
                                                <center>
                                                    <a href="#" class="text-center">
                                                        <?php
                                                        $default = base_url('assets-' . app_version() . '/') . 'dist/img/no-image.png';
                                                        if (get_image_by_parent($m['ref_sid']) != null) {
                                                            $default = 'data:image/jpeg;base64,' . get_image_by_parent($m['ref_sid']);
                                                        }
                                                        ?>
                                                        <img class="icon-client-menu-img change-icon"
                                                             src="<?= $default ?>"
                                                             data-sid="<?= $m['ref_sid'] ?>"
                                                             data-desc="<?= $m['ref_name'] ?>"
                                                             id="render-avatar"
                                                             class="circular-fix has-shadow border marg-top10"
                                                             data-ussuid="<?php print base64_encode(1); ?>" data-backdrop="static"
                                                             data-keyboard="false" data-upltype="avatar">
                                                    </a>
                                                </center>

                                                <div class="text-center mt-1"><?= $m['ref_name'] ?></div>
                                                <div class="text-center">
                                                    <span class="badge btn-secondary"><?= $m['ref_description'] ?></span>
                                                </div>

                                            </div>
                                            <!-- /.card-body -->
                                        </div>
                                    </div>
                                    <!-- /.card -->
                                <?php endforeach; ?>

                            </div>
                        </div><!-- /.card -->
                    </div>

                </div>
                <!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content -->
</section>
<!-- /.content -->



<!-- Cropping modal -->
<div id="crop-avatar">
    <div class="modal fade" id="avatar-modal" aria-hidden="true" aria-labelledby="avatar-modal-label" role="dialog" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content panel-primary">
                <form class="avatar-form" action="<?= base_url(); ?>cl_menu/upload" enctype="multipart/form-data" method="post">
                    <div class="modal-header panel-heading">
                        <h4 class="modal-title">Change Icon</h4>
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
                                <input type="hidden" id="data-sid" name="data_sid">
                                <input type="hidden" id="data-desc" name="data_desc">
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
<div class="loading" aria-label="Loading" role="img" tabindex="-1"></div>

<script src="<?= base_url('assets-'.app_version().'/') ?>plugins/jquery/jquery-3.3.1.js"></script>
<script src="<?= base_url('assets-'.app_version().'/') ?>plugins/crop/js/cropper.js"></script>
<script src="<?= base_url('assets-'.app_version().'/') ?>plugins/crop/js/main-icon.js" type="module"></script>

<script>
    $(document).ready(function(){
        $('.change-icon').click(function () {
            let data_sid = $(this).data('sid');
            let data_desc = $(this).data('desc');
            $('#data-sid').val(data_sid);
            $('#data-desc').val(data_desc);
            $('#avatar-modal').modal('show');
        });
    });
</script>