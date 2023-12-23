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
    let option1, option2, option3;
    $.get(BASE_URL + 'show/page2/chart_data/' + unit, function (result) {

        const data = JSON.parse(result)
        const tooltipBox = {
            feature: {
                dataView: {show: false, readOnly: false},
                magicType: {show: false, type: ['bar']},
                restore: {show: false},
                saveAsImage: {show: false}
            }
        }
        const tooltipOpt = {
            trigger: 'axis',
            axisPointer: {
                type: 'cross',
                crossStyle: {
                    color: '#999'
                }
            }
        }
        option1 = {
            tooltip: tooltipOpt,
            toolbox: tooltipBox,
            legend: {
                show: true,
                data: ['Last Week', 'This Week']
            },
            xAxis: [
                {
                    type: 'category',
                    data: data['chart1_last_week'].map((it) => it['date_time']),
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
                    // interval: 50,
                    axisLabel: {
                        formatter: '{value}'
                    },
                },
            ],
            series: [
                {
                    name: 'Last Week',
                    type: 'bar',
                    tooltip: {
                        valueFormatter: function (value) {
                            return value + ' ml';
                        }
                    },
                    data: data['chart1_last_week'].map((it) => it['value']),
                },
                {
                    name: 'This Week',
                    type: 'bar',
                    tooltip: {
                        valueFormatter: function (value) {
                            return value + ' ml';
                        }
                    },
                    data: data['chart1_this_week'].map((it) => it['value']),
                },
            ]
        };
        option2 = {
            tooltip: tooltipOpt,
            toolbox: tooltipBox,
            legend: {
                show: true,
                data: ['Last Month', 'This Month']
            },
            xAxis: [
                {
                    type: 'category',
                    data: data['chart2_last_month'].map((it) => it['date_time']),
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
                    // interval: 50,
                    axisLabel: {
                        formatter: '{value}'
                    },
                },
            ],
            series: [
                {
                    name: 'Last Month',
                    type: 'bar',
                    tooltip: {
                        valueFormatter: function (value) {
                            return value + ' ml';
                        }
                    },
                    data: data['chart2_last_month'].map((it) => it['value']),
                },
                {
                    name: 'This Month',
                    type: 'bar',
                    tooltip: {
                        valueFormatter: function (value) {
                            return value + ' ml';
                        }
                    },
                    data: data['chart2_this_month'].map((it) => it['value']),
                },
            ]
        };
        option3 = {
            tooltip: tooltipOpt,
            toolbox: tooltipBox,
            legend: {
                show: true,
                data: ['Previous Last 7 days', 'Last 7 days']
            },
            xAxis: [
                {
                    type: 'category',
                    data: data['chart3_last_7days'].map((it) => it['date_time']),
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
                    // interval: 50,
                    axisLabel: {
                        formatter: '{value}'
                    },
                },
            ],
            series: [
                {
                    name: 'Previous Last 7 days',
                    type: 'bar',
                    tooltip: {
                        valueFormatter: function (value) {
                            return value + ' ml';
                        }
                    },
                    data: data['chart3_last_7days'].map((it) => it['value']),
                },
                {
                    name: 'Last 7 days',
                    type: 'bar',
                    tooltip: {
                        valueFormatter: function (value) {
                            return value + ' ml';
                        }
                    },
                    data: data['chart3_this_7days'].map((it) => it['value']),
                },
            ]
        };

        option1 && myChart1.setOption(option1);
        option2 && myChart2.setOption(option2);
        option3 && myChart3.setOption(option3);
    })


    setTimeout(() => {
        window.location.replace(BASE_URL + "show/page3/"+unit);
    }, 5000);
});
