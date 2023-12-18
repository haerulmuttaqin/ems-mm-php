<!-- Main content -->
<section class="content">
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-10">
                    <div class="card card-primary card-outline">
                        <div class="card-body">

                            <?= form_error('title',
                                '<div class="alert alert-danger" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true">&times;</span>
              </button>', '</div>') ?>
                            <?= form_error('menu_id',
                                '<div class="alert alert-danger" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true">&times;</span>
              </button>', '</div>') ?>
                            <?= form_error('url',
                                '<div class="alert alert-danger" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true">&times;</span>
              </button>', '</div>') ?>
                            <?= form_error('icon',
                                '<div class="alert alert-danger" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true">&times;</span>
              </button>', '</div>') ?>

                            <?= $this->session->flashdata('message');?>

                            <a href="" class="btn btn-primary mb-3 modalAddSubmenu" data-toggle="modal" data-target="#modalMenu">Add New
                                Submenu</a>

                            <table class="table table-hover">
                                <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Title</th>
                                    <th scope="col">Menu</th>
                                    <th scope="col">Url</th>
                                    <th scope="col">Active</th>
                                    <th scope="col">Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php $i = 1; ?>
                                <?php foreach ($submenu as $sm) : ?>
                                    <tr>
                                        <th scope="row"><?= $i; ?></th>
                                        <td><?= $sm['title'] ?></td>
                                        <td><?= $sm['menu'] ?></td>
                                        <td><?= $sm['url'] ?></td>
                                        <td><?= $sm['is_active'] ?></td>
                                        <td>
                                            <a class="badge badge-success modalUpdateSubmenu" href="" data-id="<?= $sm['id']
                                            ?>" data-toggle="modal" data-target="#modalMenu"><small>EDIT</small></a>
                                            <a class="badge badge-danger" href="<?= base_url('menu/deleteSubmenu/') . $sm['id']?>"
                                               onclick="return confirm('Are you sure?')">
                                                <small>DELETE</small>
                                            </a>
                                        </td>
                                    </tr>
                                    <?php $i++; ?>
                                <?php endforeach; ?>
                                </tbody>
                            </table>

                        </div>
                    </div><!-- /.card -->
                </div>

            </div>
            <!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
</section>

<!-- Modal -->
<div class="modal fade" id="modalSubMenu" tabindex="-1" role="dialog" aria-labelledby="modalMenuTitle"
     aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalMenuTitle">Modal title</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="" method="post">
                <div class="modal-body">
                    <input type="hidden" id="id" name="id">
                    <div class="form-group">
                        <label for="title">Submenu title</label>
                        <input type="text" class="form-control" id="title" name="title">
                    </div>
                    <div class="form-group">
                        <select id="menu_id" name="menu_id" class="form-control">
                            <option value="" selected disabled>Select Menu</option>
                            <?php foreach ($menu as $m) : ?>
                                <option value="<?= $m['id'] ?>"><?= $m['menu'] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="url">Submenu url</label>
                        <input type="text" class="form-control" id="url" name="url">
                    </div>
                    <div class="form-group">
                        <input class="from-check-input" type="checkbox" value="1" name="is_active" id="is_active"
                               checked>
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