import {BASE_URL, APP_VERSION, ticksStyle, showDialogError} from "./main.js";

$(function () {
    "use strict";

    const chartDom1 = document.getElementById("chart1");
    const chartDom2 = document.getElementById("chart2");
    const chartDom3 = document.getElementById("chart3");
    const myChart1 = echarts.init(chartDom1);
    const myChart2 = echarts.init(chartDom2);
    const myChart3 = echarts.init(chartDom3);
    let option;
    $.get(BASE_URL + 'pages/page1/pie_data', function (result) {

        const data = JSON.parse(result)

        option = {
            tooltip: {
                trigger: 'axis',
                axisPointer: {
                    type: 'cross',
                    crossStyle: {
                        color: '#999'
                    }
                }
            },
            toolbox: {
                feature: {
                    dataView: {show: false, readOnly: false},
                    magicType: {show: false, type: ['bar']},
                    restore: {show: false},
                    saveAsImage: {show: false}
                }
            },
            legend: {
                data: ['Daya Gedung Bulan Lalu', 'Daya Gedung Bulan Ini']
            },
            xAxis: [
                {
                    type: 'category',
                    data: ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'],
                    axisPointer: {
                        type: 'shadow'
                    }
                }
            ],
            yAxis: [
                {
                    type: 'value',
                    name: 'kW',
                    min: 0,
                    // max: 100,
                    interval: 50,
                    axisLabel: {
                        formatter: '{value}'
                    },
                },
            ],
            series: [
                {
                    name: 'Evaporation',
                    type: 'bar',
                    tooltip: {
                        valueFormatter: function (value) {
                            return value + ' ml';
                        }
                    },
                    data: [
                        2.0, 4.9, 7.0, 23.2, 25.6, 76.7, 15.6, 62.2, 32.6, 20.0, 66.4, 63.3
                    ]
                },
                {
                    name: 'Precipitation',
                    type: 'bar',
                    tooltip: {
                        valueFormatter: function (value) {
                            return value + ' ml';
                        }
                    },
                    data: [
                        42.6, 15.9, 19.0, 26.4, 28.7, 70.7, 45.6, 82.2, 48.7, 18.8, 46.0, 72.3
                    ]
                },
            ]
        };

        option && myChart1.setOption(option);
        option && myChart2.setOption(option);
        option && myChart3.setOption(option);
    })


    setTimeout(() => {
        window.location.replace(BASE_URL + "pages/page3");
    }, 5000);
});
