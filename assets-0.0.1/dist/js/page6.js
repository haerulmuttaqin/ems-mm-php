import {BASE_URL, APP_VERSION, ticksStyle, showDialogError} from "./main.js";

$(function () {
    "use strict";

    const unit = $('#unit').val()


    const chartDom1 = document.getElementById("chart1");
    const chartDom2 = document.getElementById("chart2");
    const chartDom3 = document.getElementById("chart3");
    const myChart1 = echarts.init(chartDom1);
    const myChart2 = echarts.init(chartDom2);
    const myChart3 = echarts.init(chartDom3);
    let option;

    $.get(BASE_URL + 'show/page1/pie_data/mm', function (result) {

        const data = JSON.parse(result)

        option = {
            title: {
                left: 'center'
            },
            tooltip: {
                trigger: 'item'
            },
            legend: {
                orient: 'vertical',
                bottom: 'bottom'
            },
            series: [
                {
                    name: 'Access From',
                    type: 'pie',
                    radius: '50%',
                    data: [
                        {value: 1048, name: 'Lantai 1'},
                        {value: 735, name: 'Lantai 2'},
                        {value: 580, name: 'Lantai 3'},
                        {value: 484, name: 'Lantai 4'},
                        {value: 300, name: 'Lantai 5'}
                    ],
                    emphasis: {
                        itemStyle: {
                            shadowBlur: 10,
                            shadowOffsetX: 0,
                            shadowColor: 'rgba(0, 0, 0, 0.5)'
                        }
                    }
                }
            ]
        };

        option && myChart1.setOption(option);
        option && myChart2.setOption(option);
        option && myChart3.setOption(option);
    })


    setTimeout(() => {
        window.location.replace(BASE_URL + "show/page7/"+unit);
    }, 5000);
});
