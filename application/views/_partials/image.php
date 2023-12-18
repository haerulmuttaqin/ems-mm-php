<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="<?= base_url('assets-'.app_version().'/') ?>plugins/view-bigimg/view-bigimg.css">
    <link rel="shortcut icon" href="<?= base_url('assets-'.app_version().'/') ?>dist/img/icon.png" />
    <title><?= app_name() . ' — ' . $image_data['data_sid'] ?></title>
</head>
<body style="background-color: black;">
    <img id="wrap" style="display: block; width: auto; height: 100% !important; margin: auto; vertical-align: middle;"
         src="data:image/jpeg;base64, <?= $image_data['data'] ?>">
</body>
<script src="<?= base_url('assets-'.app_version().'/') ?>plugins/view-bigimg/view-bigimg.js"></script>
<script>
    let wrap = document.getElementById('wrap')
    let viewer = new ViewBigimg()
    let image = wrap.attributes.src.value
    viewer.show(image)
    wrap.onclick = function (e) {
        if (e.target.nodeName === 'IMG') {
            // viewer.show(e.target.src.replace('.jpg', '-big.jpg'))
            viewer.show(e.target.src)
        }
    }
    let close = document.getElementsByClassName('iv-close')
    close[0].onclick = function (e) {
        console.log('close');
        window.close();
    }
</script>
</html>
