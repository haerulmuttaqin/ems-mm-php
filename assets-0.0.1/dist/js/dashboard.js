import { BASE_URL, APP_VERSION, ticksStyle, showDialogError } from "./main.js";

$(function () {
    'use strict'

    let id = $('#meter_sid').val();
    let val = $('#record_value').val();
    setupPhoto(id)

    var chartDom = document.getElementById('gauge');
    var myChart = echarts.init(chartDom);
    var option;


    option = {
        series: [{
            type: 'gauge',
            min: 0,
            max: 90000 / 100,
            splitNumber: 12,
            itemStyle: {
                shadowColor: 'rgba(0,138,255,0.45)',
                shadowBlur: 10,
                shadowOffsetX: 2,
                shadowOffsetY: 2
            },
            progress: {
                show: true,
                roundCap: true,
                width: 1
            },
            tooltip: {
                trigger: 'axis',
                position: function (pt) {
                    return [pt[0], '10%'];
                }
            },
            axisLine: {
                lineStyle: {// Set the style of the coordinate axis
                    width: 23,
                    color: [
                        [1, new echarts.graphic.LinearGradient(0, 0, 1, 0, [
                            {
                                offset: 0.1,
                                color: 'rgba(0, 237, 99, 1)'
                            },
                            {
                                offset: 1,
                                color: 'rgba(0, 156, 171, 1)'
                            }
                        ])
                        ]
                    ]
                }
            },
            axisTick: {
                distance: -36,
                length: 16,
                lineStyle: {
                    color: '#fff',
                    width: 0.5
                }
            },
            splitLine: {
                distance: -20,
                length: 30,
                lineStyle: {
                    color: '#fff',
                    width: 1
                }
            },
            pointer: {
                icon: 'path://M2090.36389,615.30999 L2090.36389,615.30999 C2091.48372,615.30999 2092.40383,616.194028 2092.44859,617.312956 L2096.90698,728.755929 C2097.05155,732.369577 2094.2393,735.416212 2090.62566,735.56078 C2090.53845,735.564269 2090.45117,735.566014 2090.36389,735.566014 L2090.36389,735.566014 C2086.74736,735.566014 2083.81557,732.63423 2083.81557,729.017692 C2083.81557,728.930412 2083.81732,728.84314 2083.82081,728.755929 L2088.2792,617.312956 C2088.32396,616.194028 2089.24407,615.30999 2090.36389,615.30999 Z',
                length: '65%',
                width: 8,
                offsetCenter: [0, '5%']
            },
            axisLabel: {
                color: '#9c9c9c',
                distance: -35,
                fontSize: 10
            },
            detail: {
                show: false,
            },
            data: [{
                value: val / 1000
            }]
        }]
    };

    option && myChart.setOption(option);



    var chartDom2 = document.getElementById('main');
    var myChart2 = echarts.init(chartDom2);
    var option2;

    var date = [];
    var data = [];
    var min;
    $.getJSON(BASE_URL + 'dashboard/get_chart_data/' + id, function (result) {
        min = result[0].val;
        result.forEach(function (item) {
            date.push(item.date);
            data.push(item.val);
        })
    }).done(function () {
        option2 = {
            tooltip: {
                trigger: 'axis'
            },
            grid: {
                height: 200,
                left: 65,
                right: 30,
            },
            title: {
                left: 20,
                text: 'Value Hourly',
            },
            xAxis: {
                type: 'category',
                data: date,
            },
            yAxis: {
                type: 'value',
                boundaryGap: [10, '100%'],
                min: min,
                max: data[data.size]
            },
            series: [
                {
                    name: 'kWh',
                    type: 'line',
                    symbol: 'none',
                    itemStyle: {
                        color: '#2d1ccc'
                    },
                    areaStyle: {
                        color: new echarts.graphic.LinearGradient(0, 0, 0, 1, [{
                            offset: 0,
                            color: 'rgba(0, 237, 99, 1)'
                        }, {
                            offset: 1,
                            color: 'rgba(0, 156, 171, 1)'
                        }])
                    },
                    data: data
                }
            ]
        };
        option2 && myChart2.setOption(option2);
    })

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
            images.push(BASE_URL + 'assets-' + APP_VERSION + '/dist/img/meter_default.png')
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