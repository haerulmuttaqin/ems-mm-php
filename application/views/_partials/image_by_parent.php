<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="shortcut icon" href="<?= base_url('assets-'.app_version().'/') ?>dist/img/icon.png" />
    <title><?= app_name() . ' — Dokumentasi' ?></title>
</head>
<body style="background-color: black;">
    <?php foreach ($dataimage as $d) : ?>
    <img id="wrap" style="display: block; width: auto; height: 100% !important; margin: auto; vertical-align: middle;"
         src="data:image/jpeg;base64, <?= $d['data'] ?>">
    <?php endforeach; ?>
</body>
</html>
