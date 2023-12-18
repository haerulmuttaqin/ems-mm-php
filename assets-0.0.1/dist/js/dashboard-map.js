import { ACCESS_TOKEN, BASE_URL, USER_DATA, redirectOnError, showDialogError, generateSid } from "./main.js";

$(function () {
    'use strict'
    let isHide = true
    mapboxgl.accessToken = ACCESS_TOKEN;
    var map = new mapboxgl.Map({
        container: 'map', // container id
        style: 'mapbox://styles/haerulmuttaqin/cklgntq5s14c217qsc8n5twss', // style URL
        // center: [124.88619232, 1.46644601], // starting position [lng, lat]
        center: [124.4447273, 1.1632782], // starting position [lng, lat]
        // center: [83.85571549546728, 26.36946242456122],
        // center: [-122.447303, 37.753574],
        zoom: 9,
        preserveDrawingBuffer: true
    });
    var layerList = document.getElementById('menu');
    var inputs = layerList.getElementsByTagName('input');
    function switchLayer(layer) {
        var layerId = layer.target.id;
        map.setStyle('mapbox://styles/mapbox/' + layerId);
    }
    for (var i = 0; i < inputs.length; i++) {
        inputs[i].onclick = switchLayer;
    }
    map.on('style.load', function () {
        $('#navi').fadeIn();
        map.resize();

        map.addSource('tls_demand', {
            type: 'geojson',
            data: BASE_URL + 'sulut.json'
        });
        map.addLayer({
            id: "tls_projection",
            type: "fill",
            source: "tls_demand",
            filter: ["==", "$type", "Polygon"],
            paint: {
                "fill-outline-color": "red",
                "fill-color": "red",
                "fill-opacity": 0.3,
            }
        });

        const popup = new mapboxgl.Popup({
            closeButton: true,
            closeOnClick: false
        });

        // tslint:disable-next-line: space-before-function-paren
        map.on('mouseenter', 'tls_projection', function (e) {
            this.getCanvas().style.cursor = 'pointer';
        });

        // tslint:disable-next-line: space-before-function-paren
        map.on('mouseleave', 'tls_projection', function () {
            this.getCanvas().style.cursor = '';
        });

        map.on('click', function () {
            this.getCanvas().style.cursor = '';
            popup.remove();
        });

        map.on('click', 'tls_projection', function (e) {
            this.getCanvas().style.cursor = 'pointer';

            const coordinates = e.features[0].geometry.coordinates.slice();
            const pju_sid = e.features[0].properties.pju_sid;
            const uid = e.features[0].properties.uid;
            const lamp_cond = e.features[0].properties.lamp_cond;
            const lamp_cond_val = e.features[0].properties.lamp_cond_val;
            const conn_type = e.features[0].properties.conn_type;
            const conn_type_val = e.features[0].properties.conn_type_val;

            while (Math.abs(e.lngLat.lng - coordinates[0]) > 180) {
                coordinates[0] += e.lngLat.lng > coordinates[0] ? 360 : -360;
            }

            let htmlContent = `
            <div>
                <h5>`+ uid + `</h5>
                <table>
                    <tr>
                        <td class="text-sm">Kondisi Lampu </td>
                        <td class="text-sm">: <span class="cond-`+ lamp_cond_val + `"></span> ` + lamp_cond + `</td>
                    </tr>
                    <tr>
                        <td class="text-sm">Jenis Sambung </td>
                        <td class="text-sm">: <span class="type-`+ conn_type_val + `">` + conn_type + `</span></td>
                    </tr>
                </table>
                <a target="_blank" href="`+ BASE_URL + `data/item/` + pju_sid + `" class="mt-2">&nbsp;<i class="cil-arrow-right mr-1"></i> Show Detail</a>
            </div>
            `

            popup.setLngLat(coordinates)
                .setHTML(htmlContent)
                .addTo(this);

            map.flyTo({
                center: e.features[0].geometry.coordinates,
                zoom: 17,
                essential: true
            });

            $('.mapboxgl-popup-close-button').blur();
        });

        map.flyTo({
            center: [124.8387565, 1.4694509],
            zoom: 13, // starting zoom
            essential: true // this animation is considered essential with respect to prefers-reduced-motion
        });

    });

    map.on('idle', function () {
        $('#navi').fadeOut();
    })

    map.addControl(new mapboxgl.NavigationControl(), 'top-left');

    function refreshMap() {

        $.ajax({
            url: BASE_URL + "api/geomap",
            type: "GET",
            data: {
                pemda: $('#s_pemda').val(),
                lamp_type: $('#s_lamp_type').val(),
                lamp_cond: $('#s_lamp_cond').val(),
                conn_type: $('#s_conn_type').val(),
                uiw: $('#s_uiw').val(),
                up3: $('#s_up3').val(),
                ulp: $('#s_ulp').val(),
                status: $('#s_status').val()
            },
            error: function (err) {
                showDialogError(err.responseText);
            },
            beforeSend: function () {
                $('#navi').fadeIn();
            },
            success: function (data) {
                map.getSource('point-source').setData(data);
            }
        })
    }

});
