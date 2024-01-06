import {BASE_URL, APP_VERSION, ticksStyle, getDaysInMonth, getRandomColor} from "./main.js";

$(function () {
    "use strict";

    const unit = $('#unit').val()
    const dash = JSON.parse($('#dash').val())
    const timeInterval = dash.find((ref) => ref.ref_name === "TIME_INTERVAL")['ref_value'];

    const chartDom1 = document.getElementById("chart1");
    const chartDom2 = document.getElementById("chart2");
    const chartDom3 = document.getElementById("chart3");
    const chartDom4 = document.getElementById("chart4");
    const myChart1 = echarts.init(chartDom1);
    const myChart2 = echarts.init(chartDom2);
    const myChart3 = echarts.init(chartDom3);
    const myChart4 = echarts.init(chartDom4);
    let option, option2, option3, option4;
    $.get(BASE_URL + 'show/page4/chart_data/' + unit, function (result) {

        const data = JSON.parse(result)
        const thisMonth = []
        thisMonth.push(
            ['amount', 'Tanggal'],
        )
        getDaysInMonth().map((day) => {
            const itemThis = data['chart1'].find((it) => it['date_time'] === day)
            thisMonth.push(itemThis ? [itemThis['value'] || 0, 'Tanggal ' + itemThis.date_time] : [0, 'Tanggal ' + day])
        })
        option = {
            dataset: {
                source: thisMonth
            },
            grid: { containLabel: true },
            xAxis: { name: 'kW' },
            yAxis: { type: 'category' },
            series: [
                {
                    type: 'bar',
                    itemStyle: {
                        color: function (param) {
                            return getRandomColor() || '#5470c6';
                        }
                    },
                    encode: {
                        x: 'amount',
                        y: 'Tanggal'
                    }
                }
            ]
        };

        option && myChart1.setOption(option);

        const pieData2 = []
        data['chart2'].map((item) => {
            pieData2.push({value: Math.round(item.value) || 0, name: item.caption})
        })
        option2 = {
            title: {
                left: 'center'
            },
            tooltip: {
                trigger: 'item'
            },
            series: [
                {
                    name: 'DAYA KERJA',
                    type: 'pie',
                    radius: '50%',
                    data: pieData2,
                    emphasis: {
                        itemStyle: {
                            shadowBlur: 10,
                            shadowOffsetX: 0,
                            shadowColor: 'rgba(0, 0, 0, 0.5)'
                        }
                    },
                    itemStyle: {
                        color: function (param) {
                            return getRandomColor() || '#5470c6';
                        }
                    },
                }
            ]
        };
        option2 && myChart2.setOption(option2);


        const pieData3 = []
        data['chart3'].map((item) => {
            pieData3.push({value: Math.round(item.value) || 0, name: item.caption})
        })
        option3 = {
            title: {
                left: 'center'
            },
            tooltip: {
                trigger: 'item'
            },
            series: [
                {
                    name: 'DAYA LIFT',
                    type: 'pie',
                    radius: '50%',
                    data: pieData3,
                    emphasis: {
                        itemStyle: {
                            shadowBlur: 10,
                            shadowOffsetX: 0,
                            shadowColor: 'rgba(0, 0, 0, 0.5)'
                        }
                    },
                    itemStyle: {
                        color: function (param) {
                            return getRandomColor() || '#5470c6';
                        }
                    },
                }
            ]
        };
        option3 && myChart3.setOption(option3);

        const pieData4 = []
        data['chart4'].map((item) => {
            pieData4.push({value: Math.round(item.value) || 0, name: item.caption})
        })
        option4 = {
            title: {
                left: 'center'
            },
            tooltip: {
                trigger: 'item'
            },
            series: [
                {
                    name: 'DAYA LIGHTING',
                    type: 'pie',
                    radius: '50%',
                    data: pieData4,
                    emphasis: {
                        itemStyle: {
                            shadowBlur: 10,
                            shadowOffsetX: 0,
                            shadowColor: 'rgba(0, 0, 0, 0.5)'
                        }
                    },
                    itemStyle: {
                        color: function (param) {
                            return getRandomColor() || '#5470c6';
                        }
                    },
                }
            ]
        };
        option4 && myChart4.setOption(option4);
    })


    setTimeout(() => {
        window.location.replace(BASE_URL + "show/page5/"+unit);
    }, timeInterval);
});
