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
                            <span class="card-title ml-2">Module Access Configuration</span>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-3 border-right mb-3">
                                    <div class="nav flex-column nav-pills roletab" id="nav-tab" role="tablist">
                                        <?php $i = 0;
                                        foreach ($roles as $item) : ?>
                                            <a class="nav-item nav-link text-small text-truncate <?php if ($item['ref_sid'] == $resume) {
                                                                                                        echo 'active';
                                                                                                    } ?>" id="nav-home-tab" data-toggle="tab" href="#tab<?= $item['ref_sid'] ?>" role="tab" aria-controls="nav-home" aria-selected="true">
                                                <i class="fas <?php if ($item['ref_value'] > 0) {
                                                                    echo 'fa-user-tie';
                                                                } else {
                                                                    echo 'fa-user-astronaut';
                                                                } ?> mr-2"></i>
                                                <?= $item['ref_name'] ?>
                                                <?php if ($item['ref_value'] == 0) {
                                                    echo '<i class="fas fa-check-circle text-primary"></i>';
                                                } ?>
                                            </a>
                                        <?php endforeach; ?>
                                    </div>
                                </div>
                                <div class="col-lg-9">
                                    <div class="tab-content" id="nav-tabContent">
                                        <?php $i = 0;
                                        foreach ($roles as $item) : ?>
                                            <div class="tab-pane fade show <?php if ($item['ref_sid'] == $resume) {
                                                                                echo 'active';
                                                                            } ?>" id="tab<?= $item['ref_sid']; ?>" role="tabpanel" aria-labelledby="nav-home-tab">
                                                <!--CHILD-->
                                                <div class="col-md-12" style="background-color: white">
                                                    <table class="table table-sm table-bordered table-striped" id="data-<?= $item['ref_sid'] ?>" style="width: 100% !important; background-color: white ">
                                                        <thead>
                                                            <tr>
                                                                <th>#</th>
                                                                <th>Module</th>
                                                                <th>Feature</th>
                                                                <th>Access</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php $i = 1;
                                                            $role_id = $this->session->userdata('user_role_sid');
                                                            $queryMenu = "select menu.menu_sid, menu.menu, sub.sub_sid, sub.sub
                                                                        from user_menu menu
                                                                        inner join user_sub_menu as sub on menu.menu_sid = sub.menu_sid
                                                                        order by menu.sort ASC";
                                                            $menuRole = $this->db->query($queryMenu)->result_array();

                                                            foreach ($menuRole as $m) : ?>
                                                                <tr class="updateMenu">
                                                                    <td>
                                                                        <?= $i++; ?>
                                                                    </td>
                                                                    <td>
                                                                        <span class="badge <?php if ($m['menu'] == 'Admin') {
                                                                                                echo 'badge-danger';
                                                                                            } else {
                                                                                                echo 'badge-secondary';
                                                                                            } ?>"> <?= $m['menu'] ?> </span>
                                                                    </td>
                                                                    <td>
                                                                        <?= $m['sub'] ?>
                                                                    </td>
                                                                    <td>
                                                                        <div class="pretty p-svg p-curve">
                                                                            <input class="form-check-input-client-sub" type="checkbox" <?php if ($m['menu'] == 'Admin') echo 'disabled' ?> <?= check_access(
                                                                                                                                                                                                $item['ref_sid'],
                                                                                                                                                                                                $m['sub_sid']
                                                                                                                                                                                            ); ?> data-role="<?= $item['ref_sid']; ?>" data-menu="<?= $m['menu_sid']; ?>" data-sub="<?= $m['sub_sid']; ?>" data-name="<?= $m['sub']; ?>" />
                                                                            <div class="state p-success">
                                                                                <svg class="svg svg-icon" viewBox="0 0 20 20">
                                                                                    <path d="M7.629,14.566c0.125,0.125,0.291,0.188,0.456,0.188c0.164,0,0.329-0.062,0.456-0.188l8.219-8.221c0.252-0.252,0.252-0.659,0-0.911c-0.252-0.252-0.659-0.252-0.911,0l-7.764,7.763L4.152,9.267c-0.252-0.251-0.66-0.251-0.911,0c-0.252,0.252-0.252,0.66,0,0.911L7.629,14.566z" style="stroke: white;fill:white;"></path>
                                                                                </svg>
                                                                                <label></label>
                                                                            </div>
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                            <?php endforeach; ?>
                                                        </tbody>
                                                    </table>
                                                </div>
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