<!-- Main content -->
<section class="content">

    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card card-primary card-outline">
                        <div class="card-header bg-gray-light">
                            <h3 class="card-title"><button class="btn btn-default btn-sm go-back mr-2" title="Go Back" data-toggle="tooltip" data-placement="right"><i class="cil-arrow-left mr-1 font-weight-bold"></i></button> Error Logs Information</h3>
                        </div>
                        <div class="card-body">
                            <table class="table table-sm table-striped" id="error-table" style="width: 100%">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Message</th>
                                        <th>Error Identifier</th>
                                        <th>Date of Record</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>


<div class="modal fade" id="show-error" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h5 class="modal-title" id="exampleModalLabel"><b>...</b></h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <table class="table table-sm" id="error-table" style="width: 100%">
                    <thead>
                        <tr>
                            <th>Error Message</th>
                        </tr>
                        <tr>
                            <td id="_message">...</td>
                        </tr>
                        <tr>
                            <th>Error Identifier</th>
                        </tr>
                        <tr>
                            <td id="_id">...</td>
                        </tr>
                        <tr>
                            <th>Date of Record</th>
                        </tr>
                        <tr>
                            <td id="_date">...</td>
                        </tr>
                    </thead>
                </table>
            </div>
            <div class="modal-footer" style="display: block !important;">
                <div id="transaction-body-modal"></div>
                <button id="delete_error" type="button" class="btn btn-danger float-left"><i class="fas fa-trash"></i> &nbsp;Delete</button>
                <button type="button" class="btn btn-secondary float-right" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<?php $this->load->view('_partials/footer'); ?>
<script src="<?= base_url('assets-' . app_version() . '/') ?>dist/js/user.js" type="module"></script>