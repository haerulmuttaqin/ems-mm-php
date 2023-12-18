import { BASE_URL, USER_DATA, APP_VERSION, ACCESS_TOKEN, showDialogError, timeConversion, setupSortable, alertDelete, Toast, showDialogSuccess, showDialogErrorDeleted, showDialogSuccessDeleted } from "./main.js";
$(function () {
    let sid = $('#meter_sid').val()
    $('#edit').click(function () { window.location.href = BASE_URL + 'meter/update/' + sid })
    loadItem(sid)
    function loadItem(sid) {
        $.ajax({
            url: BASE_URL + 'meter/get_by_sid/' + sid,
            type: 'GET',
            contentType: "application/json",
            dataType: "json",
            headers: { 'authorization': USER_DATA.user_token },
            beforeSend: function (request) {
                request.setRequestHeader("authorization", USER_DATA.user_token);
            },
            error: function (err) {
                showDialogError(err)
            },
            success: function (data) {
                if (data.status) {
                    if (data.data != null) {
                        /*------------- SETUP DATA ------------  */
                        setupData(data.data)
                    } else {
                        showDialogError(data.message)
                    }
                } else {
                    showDialogError(data.message)
                }
            }
        })
    }

    function setupData(data) {
        $('#meter_name').text(data.meter_name)
        $('#group').text(data.meter_group)
        $('#serial').text(data.meter_serial)
        $('#alias').text(data.meter_alias == '' || data.meter_alias == null ? '[not set]' : data.meter_alias)
        $('#tarif').text(data.meter_tarif == '' || data.meter_tarif == null ? '[not set]' : data.meter_tarif)
        $('#pju').text(data.meter_pju == '' || data.meter_pju == null ? '' : data.meter_pju)
        if (data.meter_pju_has_custom == 1) {
            $('#pju').append(' <small>(has custom)</small>')
        } else {
            $('#pju').append(' <small>(has default by master config)</small>')
        }
        $('#pc_factor').text(data.meter_pc_factor == '' || data.meter_pc_factor == null ? '[not set]' : data.meter_pc_factor)
        $('#pc_mccb').text(data.meter_pc_mccb == '' || data.meter_pc_mccb == null ? '[not set]' : data.meter_pc_mccb)
        $('#pc_daya').text(data.meter_pc_daya == '' || data.meter_pc_daya == null ? '[not set]' : data.meter_pc_daya)
        $('#remark').text(data.remark == '' || data.remark == null ? '[not set]' : data.remark)
        $('#location').text(data.location == '' || data.location == null ? '[not set]' : data.location)
        $('#post_date').text(moment(data.post_date).format('DD MMM YYYY  HH:mm:ss'))
        $('#update_date').text(moment(data.update_date).format('DD MMM YYYY  HH:mm:ss'))
        setupPhoto(data.meter_sid)
        var qrcode = new QRCode("data-qr", {
            text: data.meter_name,
            width: 75,
            height: 75,
            colorDark: "#000000",
            colorLight: "#ffffff",
            correctLevel: QRCode.CorrectLevel.H
        });
        qrcode.clear(); // clear the code.
        qrcode.makeCode(data.meter_name);

        var qrcodePrint = new QRCode("data-qr-print", {
            text: data.meter_name,
            width: 140,
            height: 140,
            colorDark: "#000000",
            colorLight: "#ffffff",
            correctLevel: QRCode.CorrectLevel.H
        });
        qrcodePrint.clear(); // clear the code.
        qrcodePrint.makeCode(data.meter_name);
        /* $('#td_uid-print').text(data.prefix_name + data.td_uid)
        $('#tube-print').text(data.tb_brand_name + ", " + data.tb_type_name + " - " + data.tb_capacity_name)
        $('#unit-print').text(data.prefix_name + " - " + data.td_unit_name)
        $('#location-print').html('LOKASI: ' + data.td_location_name + " / " + data.td_place)
        $('#remark-print').html('KETERANGAN: ' + data.td_remark)
        $('#expired-print').html('KADALUARSA: ' + data.expired_date_formated.toUpperCase()) */
    }

    $("#data-qr").on("click", function () {
        $('#imagepreview').html('');
        var qrcode2 = new QRCode("imagepreview", {
            text: $(this).attr('title'),
            width: 275,
            height: 275,
            colorDark: "#000000",
            colorLight: "#ffffff",
            correctLevel: QRCode.CorrectLevel.H
        });
        qrcode2.clear(); // clear the code.
        qrcode2.makeCode($(this).attr('title'));
        $('#modal-label').html('QR CODE : <b>' + $('#td_uid').text() + '</b>')
        $('#imagepreview').find('img').css('margin-left', 'auto')
        $('#imagepreview').find('img').css('margin-right', 'auto')
        $('#imagemodal').modal('show'); // imagemodal is the id attribute assigned to the bootstrap modal, then i use the show function
    });

    function setupPhoto(sid) {
        var images = [];
        var text = [];
        var name = [];
        $.getJSON(BASE_URL + 'img/get_base64_by_parent/' + sid + '/METER_IMG', function (result) {
            if (result.length > 0) {
                result.forEach(function (data) {
                    images.push('data:image/png;base64,' + data.data)
                    text.push(data.desc === null || data.desc === '' ? 'NO DESCRIPTION' : data.desc)
                    var fileNameIndex = data.data_path.lastIndexOf("/") + 1;
                    var filename = data.data_path.substr(fileNameIndex);
                    name.push(filename == null || filename == '' ? 'Unititled' : filename)
                });
            } else {
                images.push(BASE_URL + 'assets-' + APP_VERSION + '/dist/img/no-image.png')
            }
        }).done(function () {
            setTimeout(() => {
                $('#data-photos').imagesGrid({
                    images: images,
                    text: text,
                    name: name,
                });
                $('.loading-image').fadeOut(100)
                $('.image-wrap').addClass('unwrap')
            }, 1000);
        });
    }

    function initMaps(lon, lat) {
        let map;
        let mapboxURL = 'https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token=' + ACCESS_TOKEN;
        let mapboxAttribution = 'Map data &copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors, Style © <a href="https://www.mapbox.com/">Mapbox</a>';
        let locations = [];
        let layers = [];
        let layerMarker;
        for (let providerId in providers) {
            layers.push(providers[providerId]);
        }

        layers.push({
            layer: {
                onAdd: function () { },
                onRemove: function () { }
            },
            title: 'empty'
        });
        map = L.map('mapid').setView([-6.241586, 106.992416], 14);
        L.tileLayer(mapboxURL, {
            attribution: mapboxAttribution,
            maxZoom: 40,
            id: 'mapbox/streets-v11',
            tileSize: 512,
            zoomOffset: -1,
            accessToken: ACCESS_TOKEN
        }).addTo(map);
        L.marker([lat, lon]).addTo(map);
        map.panTo(new L.LatLng(lat, lon));
    }

});