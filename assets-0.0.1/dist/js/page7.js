import {BASE_URL, APP_VERSION, ticksStyle, showDialogError} from "./main.js";

$(function () {
    "use strict";

    const unit = $('#unit').val()

    const chartDom1 = document.getElementById("chart1");
    const chartDom2 = document.getElementById("chart2");
    const myChart1 = echarts.init(chartDom1);
    const myChart2 = echarts.init(chartDom2);
    let option, option2;

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
                        {value: 1048, name: 'PM LIFT'},
                        {value: 735, name: 'PM\n' +
                                'PENERANGAN'},
                        {value: 580, name: 'PM AC/AHU'},
                        {value: 1484, name: 'PM STOP\n' +
                                'KONTAK'},
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


        option2 = {
            xAxis: {
                type: 'category',
                data: ['12:00', '12:30', '11:00', '11:30', '10:00', '10:30', '12:00', '12:10', '11:20', '11:10', '10:10', '10:10', '09:10']
            },
            yAxis: {
                type: 'value'
            },
            series: [
                {
                    data: [120, 200, 150, 80, 70, 110, 130, 120, 200, 150, 80, 70, 110, 130],
                    type: 'bar'
                }
            ]
        };


        option && myChart1.setOption(option);
        option2 && myChart2.setOption(option2);
    })


    setTimeout(() => {
        window.location.replace(BASE_URL + "show/page1/"+unit);
    }, 5000);
});
