<!-- Main content -->
<section class="content">
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card card-secondary card-outline">
                        <div class="card-header bg-gray-light">
                            <button id="filter" type="button" class="btn btn-sm btn-default go-back" title="Go Back" data-toggle="tooltip" data-placement="right">
                                <i class="cil-arrow-left mr-1 font-weight-bold"></i>
                            </button>
                            <span class="card-title ml-2">Data Configuration</span>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-3 border-right">
                                    <div class="nav flex-column nav-pills ref_position" id="nav-tab" role="tablist">
                                        <a class="nav-item nav-link active border" id="nav-home-tab" data-toggle="tab" href="#tabmaster" role="tab" aria-controls="nav-home" aria-selected="true"><b>GENERIC MASTER REFERENCES</b></a>
                                        <?php $i = 0;
                                        foreach ($category as $item) : ?>
                                            <a class="nav-item nav-link text-small text-truncate" id="<?= $item['category_sid'] ?>" data-toggle="tab" href="#tab<?= $item['category_sid'] ?>" role="tab" aria-controls="nav-home" aria-selected="true"><i class="fas fa-caret-right mr-2"></i><?= $item['category_name'] ?></a>
                                        <?php endforeach; ?>
                                    </div>
                                </div>
                                <div class="col-lg-9">
                                    <div class="tab-content" id="nav-tabContent">

                                        <!--PARENT-->
                                        <div class="tab-pane fade show <?php if ($resume == null) {
                                                                            echo 'active';
                                                                        } ?>" id="tabmaster" role="tabpanel" aria-labelledby="nav-home-tab">
                                            <form class="form-sample" method="post" action="<?= base_url('master/master') ?>" style="background-color: white !important;">
                                                <div class="row">
                                                    <div class="col-md-4">

                                                        <!--DATAID-->
                                                        <input type="hidden" name="id" id="id">

                                                        <div class="form-group">
                                                            <label> Category</label>
                                                            <input type="text" class="form-control text-caps" name="name" id="name" required />
                                                            <?= form_error('name', '<small class="text-danger">', '</small>') ?>
                                                        </div>

                                                        <div class="form-group">
                                                            <label> Config parent</label>
                                                            <select name="config" class="form-control" id="config">
                                                                <option value="0">NO</option>
                                                                <option value="1">YES</option>
                                                            </select>
                                                        </div>

                                                        <div class="form-group" id="parent" style="display: none;">
                                                            <select name="parentSid" id="parentSid" class="form-control">
                                                                <option selected disabled>Select parent...</option>
                                                                <?php $i = 1;
                                                                foreach ($category as $row) : ?>
                                                                    <option value="<?= $row['category_sid'] ?>"><?= $row['category_name'] ?></option>
                                                                <?php endforeach; ?>
                                                            </select>
                                                        </div>

                                                        <div class="form-group">
                                                            <label> Description</label>
                                                            <textarea type="text" class="form-control" name="desc" id="desc"></textarea>
                                                        </div>

                                                        <div class="form-group">
                                                            <label></label>
                                                            <div class="form-radio">
                                                                <button type="submit" class="btn btn-primary" name="add" id="add">Submit Changes</button>
                                                                <a href="<?= base_url('Master') ?>" class="btn btn-secondary" id="clear">Clear</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-8">
                                                        <table class="table-master table-sm table-bordered table-striped" id="data" style="width: 100%">
                                                            <thead>
                                                                <tr>
                                                                    <th>#</th>
                                                                    <th>Reference Category</th>
                                                                    <th>Action</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody class="member">
                                                                <?php $i = 1;
                                                                foreach ($category as $row) : ?>

                                                                    <tr class="updateMenu" data-id="<?= $row['category_sid'] ?>" data-name="<?= $row['category_name'] ?>" data-desc="<?= $row['category_desc'] ?>" data-parent_sid="<?= $row['parent_sid'] ?>" data-config="<?= $row['is_config_two_level'] ?>">

                                                                        <td><?= $i++; ?></td>
                                                                        <td><?= $row['category_name'] ?></td>
                                                                        <td>

                                                                            <a href="#" class="updateMenu text-secondary" data-id="<?= $row['category_sid'] ?>" data-name="<?= $row['category_name'] ?>" data-parent_sid="<?= $row['parent_sid'] ?>" data-config="<?= $row['is_config_two_level'] ?>" data-desc="<?= $row['category_desc'] ?>">
                                                                                <i class="fas fa-pen"></i></a>
                                                                            &nbsp;
                                                                            <a onclick="return confirm('Are you sure?')" href="<?= base_url('master/deleteMaster?delete_id=') . $row['category_sid'] ?>" class="text-secondary"><i class="fas fa-trash"></i></a>
                                                                        </td>
                                                                    </tr>

                                                                <?php endforeach; ?>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>

                                        <?php $i = 0;
                                        foreach ($category as $item) : ?>
                                            <div class="tab-pane fade show <?php if ($item['category_sid'] == $resume) {
                                                                                echo 'active';
                                                                            } ?>" id="tab<?= $item['category_sid']; ?>" role="tabpanel" aria-labelledby="nav-home-tab" style="background-color: white !important;">
                                                <!--CHILD-->
                                                <form class="form-sample mt-3" method="post" action="<?= base_url('master/masterItem/' . $item['category_sid']) ?>">
                                                    <div class="row">
                                                        <!--DATAID-->
                                                        <input type="hidden" name="id" id="id<?= $item['category_sid'] ?>">

                                                        <input type="hidden" name="cat_id" id="cat_id<?= $item['category_sid'] ?>">

                                                        <div class="form-group col-lg-2 col-sm-12">
                                                            <label> Category </label>
                                                            <input readonly aria-readonly="true" type="text" class="form-control text-caps" name="category" id="category" value="<?= $item['category_name'] ?>" />
                                                            <?= form_error('category', '<small class="text-danger">', '</small>') ?>
                                                        </div>

                                                        <div class="form-group col-lg-4 col-sm-12">
                                                            <label> Name / Title</label>
                                                            <input type="text" class="form-control text-caps" name="name" id="name<?= $item['category_sid'] ?>" required />
                                                            <?= form_error('name', '<small class="text-danger">', '</small>') ?>
                                                        </div>

                                                        <div class="form-group col-lg-2 col-sm-12">
                                                            <label> Value</label>
                                                            <input type="number" class="form-control" name="value" id="value<?= $item['category_sid'] ?>" />
                                                        </div>

                                                        <div class="form-group col-lg-4 col-sm-12">
                                                            <label> Description</label>
                                                            <input type="text" class="form-control text-caps" name="desc" id="desc<?= $item['category_sid'] ?>" />
                                                        </div>

                                                        <div class="form-group col-lg-6 col-sm-12">
                                                            <?php if ($item['parent_sid'] != null || $item['parent_sid'] != "") : ?>
                                                                <select name="parent" id="parent" class="form-control" required>
                                                                    <option value="" selected disabled>Select <?= $item['parent_name'] ?>...</option>
                                                                    <?php
                                                                    $parent_sid = $item['parent_sid'];
                                                                    $query = "select * from generic_references where category_sid = '$parent_sid' order by date_created asc";
                                                                    $parent = $this->db->query($query)->result_array();
                                                                    foreach ($parent as $row) : ?>
                                                                        <option value="<?= $row['ref_sid'] ?>"><?= $row['ref_name'] ?></option>
                                                                    <?php endforeach; ?>
                                                                </select>
                                                            <?php else : ?>
                                                                <select name="parent" id="parent" class="form-control" disabled>
                                                                    <option value="" selected disabled>N/A — <small>has parent config</small></option>
                                                                </select>
                                                            <?php endif; ?>
                                                        </div>

                                                        <div class="form-group col-lg-3 col-sm-6 text-right">
                                                            <button type="button" class="btn btn-block btn-secondary" id="clear<?= $item['category_sid'] ?>">Clear</button>
                                                        </div>
                                                        <div class="form-group col-lg-3 col-sm-6 text-right">
                                                            <button type="submit" class="btn btn-block btn-primary" name="add" id="addItem<?= $item['category_sid'] ?>">Submit Changes</button>
                                                        </div>

                                                        <div class="col-lg-12" style="margin-top: -10px !important;">
                                                            <small class="form-text text-muted">description : <?= $item['category_desc'] ?></small>
                                                        </div>

                                                        <div class="col-lg-12" style="margin-top: -10px !important;">
                                                            <small id="uuid<?= $item['category_sid'] ?>" class="form-text text-muted">uuid : </small>
                                                            <hr style="margin-top: 6px !important;">
                                                        </div>

                                                        <div class="col-md-12">
                                                            <table class="table table-sm table-bordered table-striped" id="data-<?= $item['category_sid'] ?>" style="width: 100% !important; ">
                                                                <thead>
                                                                    <tr>
                                                                        <th>#</th>
                                                                        <th>Reference Name</th>
                                                                        <th>Value</th>
                                                                        <th>Desc</th>
                                                                        <th>Action</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody class="member">
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>

                                        <?php endforeach; ?>
                                    </div>
                                </div>
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