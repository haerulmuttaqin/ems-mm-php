<div class="inner-border">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row">
                <?php foreach ($unit_data as $item) : ?>
                    <?php if ($user_data['role_value'] == 1) : ?>
                        <?php if ($user_data['user_unit'] == $item['ref_sid']) : ?>
                            <div class="col-lg-6">
                                <div class="card card-primary card-outline">
                                    <div class="card-body">
                                        <b class="text-bold float-left flex">
                                            <?= $item['ref_description'] ?>
                                        </b>
                                        <a href="<?= base_url("show/page1/a1") ?>" target="_blank"
                                           role="button" type="submit" class="flex btn btn-success float-right">
                                            <i class="fas fa-caret-square-right mr-2"></i> Show
                                        </a>
                                    </div>
                                </div>
                            </div>
                        <?php endif; ?>
                    <?php else: ?>
                        <div class="col-lg-6">
                            <div class="card card-primary card-outline">
                                <div class="card-body">
                                    <b class="text-bold float-left flex">
                                        <?= $item['ref_description'] ?>
                                    </b>
                                    <a href="<?= base_url("show/page1/mm") ?>" target="_blank"
                                       role="button" type="submit" class="flex btn btn-success float-right">
                                        <i class="fas fa-caret-square-right mr-2"></i> Show
                                    </a>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>
                <?php endforeach; ?>
            </div>
        </div>
    </section>
</div>