import {BASE_URL, APP_VERSION, ticksStyle, getDaysInMonth} from "./main.js";

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
        const dayOfWeek = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jum`at', 'Sabtu', 'Minggu']
        const lastWeek = []
        const thisWeek = []
        dayOfWeek.map((day) => {
            const itemLast = data['chart1_last_week'].find((it) => it['date_time'] === day)
            const itemThis = data['chart1_this_week'].find((it) => it['date_time'] === day)
            lastWeek.push(itemLast || {date_time: day, value: 0})
            thisWeek.push(itemThis || {date_time: day, value: 0})
        })
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
                    // data: data['chart1_last_week'].map((it) => it['date_time']),
                    data: dayOfWeek,
                    axisPointer: {
                        type: 'shadow'
                    }
                }
            ],
            yAxis: [
                {
                    type: 'value',
                    name: 'kWH',
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
                            return value + ' kWH';
                        }
                    },
                    // data: data['chart1_last_week'].map((it) => it['value']),
                    data: lastWeek
                },
                {
                    name: 'This Week',
                    type: 'bar',
                    tooltip: {
                        valueFormatter: function (value) {
                            return value + ' kWH';
                        }
                    },
                    // data: data['chart1_this_week'].map((it) => it['value']),
                    data: thisWeek
                },
            ]
        };


        // chart2
        const lastMonth = []
        const thisMonth = []
        getDaysInMonth().map((day) => {
            const itemLast = data['chart2_last_month'].find((it) => it['date_time'] === day)
            const itemThis = data['chart2_this_month'].find((it) => it['date_time'] === day)
            lastMonth.push(itemLast || {date_time: day, value: 0})
            thisMonth.push(itemThis || {date_time: day, value: 0})
        })
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
                    data: getDaysInMonth(),
                    axisPointer: {
                        type: 'shadow'
                    },
                    axisLabel: {
                        interval: 0,
                        // formatter: (function(value){
                        //     if (value) return moment(value).format('DD');
                        // })
                    }
                }
            ],
            yAxis: [
                {
                    type: 'value',
                    name: 'kWH',
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
                            return value + ' kWH';
                        }
                    },
                    data: lastMonth,
                },
                {
                    name: 'This Month',
                    type: 'bar',
                    tooltip: {
                        valueFormatter: function (value) {
                            return value + ' kWH';
                        }
                    },
                    data: thisMonth,
                },
            ]
        };

        const lastDays = [...new Set(data['chart3_last_7days'].map((it) => it['date_time']).concat(data['chart3_this_7days'].map((it) => it['date_time'])))]
        const last7Days = []
        const this7Days = []
        lastDays.map((day) => {
            const itemLast = data['chart3_last_7days'].find((it) => it['date_time'] === day)
            const itemThis = data['chart3_this_7days'].find((it) => it['date_time'] === day)
            last7Days.push(itemLast || {date_time: day, value: 0})
            this7Days.push(itemThis || {date_time: day, value: 0})
        })
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
                    data: lastDays,
                    axisPointer: {
                        type: 'shadow'
                    }
                }
            ],
            yAxis: [
                {
                    type: 'value',
                    name: 'kWH',
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
                            return value + ' kWH';
                        }
                    },
                    data: last7Days,
                },
                {
                    name: 'Last 7 days',
                    type: 'bar',
                    tooltip: {
                        valueFormatter: function (value) {
                            return value + ' kWH';
                        }
                    },
                    data: this7Days,
                },
            ]
        };

        option1 && myChart1.setOption(option1);
        option2 && myChart2.setOption(option2);
        option3 && myChart3.setOption(option3);
    })


    setTimeout(() => {
        window.location.replace(BASE_URL + "show/page3/"+unit);
    }, 15000);
});
