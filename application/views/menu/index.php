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
                            <span class="card-title ml-2">Menu Configuration</span>
                            <div class="card-tools">
                                <a href="" tyle="margin-right: 5px;" class="btn btn-primary btn-sm modalAddMenu" data-toggle="modal" data-target="#modalMenu"><i class="cil-plus mr-2"></i> Add Menu
                                </a>
                            </div>
                        </div>
                        <div class="card-body">

                            <?= form_error(
                                'menu',
                                '<div class="alert alert-danger" role="alert">',
                                '<button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                                </button></div>'
                            )
                            ?>

                            <div class="row">

                                <div class="col-sm-12 col-lg-5 mb-4">
                                    <div class="nav flex-column nav-pills">
                                        <?php $i = 1; ?>
                                        <?php foreach ($menu as $m) : ?>
                                            <div class="nav-link
                                            <?php if ($menu_item['menu'] == $m['menu']) echo 'active' ?>" data-id="<?= $m['menu_sid'] ?>" data-toggle="pill" role="tab" aria-controls="v-pills-home" aria-selected="true">
                                                <a class="btn btn-sm btn-light upMenu" data-id="<?= $m['menu_sid']; ?>" href="">
                                                    <i class="fas fa-sort-up"></i>
                                                </a>
                                                <a class="btn btn-sm btn-light downMenu" data-id="<?= $m['menu_sid']; ?>" href="">
                                                    <i class="fas fa-sort-down"></i>
                                                </a>
                                                &nbsp;
                                                <i class="<?= $m['icon'] ?>"></i>
                                                <span class="text-text-truncate"><?= $m['menu'] ?></span>
                                                <div class="float-right">
                                                    <a class="btn btn-sm btn-light showSubMenu" data-id="<?= $m['menu_sid']; ?>" href="">
                                                        <i class="fas fa-list"></i>
                                                    </a>
                                                    <a class="btn btn-sm btn-secondary modalUpdateMenu" id="modalUpdate" data-toggle="modal" data-target="#modalMenu" href="" data-id="<?= $m['menu_sid']; ?>">
                                                        <i class="fas fa-pen"></i>
                                                    </a>
                                                    <a class="btn btn-sm btn-danger daleteMenu" href="" data-id="<?= $m['menu_sid']; ?>">
                                                        <i class="fas fa-trash"></i>
                                                    </a>
                                                </div>
                                            </div>
                                        <?php endforeach; ?>
                                    </div>
                                </div>

                                <?php if (isset($submenu)) : ?>
                                    <div class="col-lg-7">
                                        <div class="tab-content" id="v-pills-tabContent">
                                            <div class="col-12">
                                                <div class="row">
                                                    <h5 class="col-6">Submenu <?= $menu_item['menu'] ?></h5>
                                                    <div class="col-6">
                                                        <a href="" class="btn btn-sm btn-primary mb-3 modalAddSubmenu float-right" data-toggle="modal" data-target="#modalSubMenu"><i class="fas fa-plus-circle"></i> Add Submenu</a>
                                                    </div>
                                                </div>
                                            </div>
                                            <?= $this->session->flashdata('message'); ?>
                                            <table class="table table-sm table-hover table-bordered" id="table-submenu">
                                                <thead>
                                                    <tr>
                                                        <th scope="col">Sub Title</th>
                                                        <th scope="col">Url</th>
                                                        <th class="text-right" scope="col">Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody class="row_position">
                                                    <?php foreach ($submenu as $sm) : ?>
                                                        <tr id="<?= $sm['sub_sid']; ?>">
                                                            <td>
                                                                <span class="btn btn-sm btn-light" style="cursor: move;" data-id="<?= $sm['sub_sid']; ?>" data-menu="<?= $sm['menu_sid']; ?>" href="">
                                                                    <i class="fas fa-sort"></i>
                                                                </span>
                                                                <?= $sm['sub'] ?>
                                                            </td>
                                                            <td><?= $sm['url'] ?></td>
                                                            <td class="text-right mr-3">
                                                                <a class="badge badge-secondary modalUpdateSubmenu" href="" data-id="<?= $sm['sub_sid']; ?>" data-toggle="modal" data-target="#modalSubMenu"><small>EDIT</small></a>
                                                                <a class="badge badge-danger <?php if ($sm['url'] == 'menu') echo 'disabled' ?>" href="<?= base_url('menu/deleteSubmenu/') . $sm['sub_sid'] . "/" . $sm['menu_sid'] ?>" onclick="return confirm('Are you sure?')">
                                                                    <small>DELETE</small>
                                                                </a>
                                                            </td>
                                                        </tr>
                                                        <?php $i++; ?>
                                                    <?php endforeach; ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                <?php endif; ?>
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

<!-- Modal -->
<div class="modal swal2-modal fade" id="modalMenu" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalLabel">Add Menu</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?= base_url('menu') ?>" method="post">
                <div class="modal-body">
                    <input type="hidden" id="id" name="id">
                    <div class="form-group">
                        <label for="Menu name">Menu Name</label>
                        <input type="text" class="form-control" id="menu" name="menu" placeholder="Menu name">
                    </div>
                    <div class="form-group">
                        <label for="Menu Icon">Menu Icon</label>
                        <input type="text" class="form-control" id="icon" name="icon" placeholder="Menu icon">
                        <div id="icon_picker" class="mt-2"></div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Add</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!--SUBMENU-->
<div class="modal swal2-modal fade" id="modalSubMenu" tabindex="-1" role="dialog" aria-labelledby="modalMenuTitle" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalMenuTitle">Tambah Submenu <?= $menu_item['menu'] ?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="" method="post">
                <div class="modal-body">
                    <input type="hidden" id="sub_sid" name="id">
                    <input type="hidden" id="menu_id" name="menu_id" value="<?= $menu_item['menu_sid'] ?>">
                    <div class="form-group">
                        <label for="title">Submenu title</label>
                        <input type="text" class="form-control" id="title" name="title">
                    </div>
                    <div class="form-group">
                        <label for="url">Submenu url</label>
                        <input type="text" class="form-control" id="url" name="url">
                    </div>
                    <div class="form-group">
                        <input class="from-check-input" type="checkbox" value="1" name="is_active" id="is_active" checked>
                        <label class="from-check-label" for="is_active">Active</label>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Add</button>
                </div>
            </form>
        </div>
    </div>
</div>