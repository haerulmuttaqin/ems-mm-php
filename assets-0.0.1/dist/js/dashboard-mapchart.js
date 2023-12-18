import { ACCESS_TOKEN, BASE_URL, USER_DATA, redirectOnError, showDialogError, generateSid } from "./main.js";

$(function () {
    'use strict'
    setupChart()
    function setupChart() {
        var dom = document.getElementById("mapchart");
        var chart = echarts.init(dom);
        var option;
        chart.showLoading();
        $.get(BASE_URL + 'manado.json', function (geoJson) {
            $.get(BASE_URL + 'dashboard/pemda_count', function (pemdaJson) {
                let data = JSON.parse(pemdaJson);
                console.log(data);

                chart.hideLoading();

                echarts.registerMap('HK', geoJson);

                chart.setOption(option = {
                    title: {
                        text: 'VISUAL GEOGRAPHIC',
                        subtext: 'Grouped by PEMDA',
                        textStyle: {
                            fontSize: 15
                        }
                    },
                    tooltip: {
                        trigger: 'item',
                        formatter: '{b}<br/>{c} PJU'
                    },
                    toolbox: {
                        show: true,
                        orient: 'horizontal',
                        left: 'left',
                        top: 'bottom',
                        feature: {
                            dataView: { readOnly: false },
                            restore: {},
                            saveAsImage: {}
                        }
                    },
                    visualMap: {
                        left: 'right',
                        min: data.range.min,
                        max: data.range.max,
                        text: ['High', 'Low'],
                        realtime: false,
                        calculable: true,
                        inRange: {
                            color: ['#83b926', 'yellow', 'orangered']
                        },
                    },
                    markArea: {
                        zlevel: 20
                    },
                    series: [
                        {
                            name: 'VISUAL GEOGRAPHIC | rouped by PEMDA',
                            type: 'map',
                            mapType: 'HK', // 自定义扩展图表类型
                            label: {
                                show: true,
                                color: '#000'
                            },
                            data: data.data,
                        }
                    ]
                });
            });
        });

        if (option && typeof option === "object") {
            chart.setOption(option, true);
        }
    }

});
