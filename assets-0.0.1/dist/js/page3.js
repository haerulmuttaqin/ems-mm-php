import {BASE_URL, APP_VERSION, ticksStyle, getRandomColor} from "./main.js";

$(function () {
    "use strict";

    const unit = $('#unit').val()


    const chartDom1 = document.getElementById("chart1");
    const chartDom2 = document.getElementById("chart2");
    const chartDom3 = document.getElementById("chart3");
    const chartDom4 = document.getElementById("chart4");
    const myChart1 = echarts.init(chartDom1);
    const myChart2 = echarts.init(chartDom2);
    const myChart3 = echarts.init(chartDom3);
    const myChart4 = echarts.init(chartDom4);
    let option, option2, option3, option4;
    $.get(BASE_URL + 'show/page3/chart_data/' + unit, function (result) {

        const data = JSON.parse(result)
        const floorData = []
        floorData.push(['amount', 'Lantai'])
        data['chart1'].map((item) => {
            floorData.push([Math.round(item.value) || 0, item.caption])
        })

        option = {
            dataset: {
                source: floorData
            },
            legend: {
                show: true
            },
            grid: {containLabel: true},
            xAxis: {name: 'Beban'},
            yAxis: {type: 'category'},
            series: [
                {
                    itemStyle: {
                        color: function (param) {
                            return getRandomColor() || '#5470c6';
                        }
                    },
                    type: 'bar',
                    encode: {
                        // Map the "amount" column to X axis.
                        x: 'amount',
                        // Map the "product" column to Y axis
                        y: 'Lantai'
                    },
                }
            ]
        };

        option && myChart1.setOption(option);


        const floorData2 = []
        data['chart2'].map((item) => {
            floorData2.push({value: Math.round(item.value) || 0, name: item.caption})
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
                    name: 'ARUS',
                    type: 'pie',
                    radius: '50%',
                    data: floorData2,
                    itemStyle: {
                        color: function (param) {
                            return getRandomColor() || '#5470c6';
                        }
                    },
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
        option2 && myChart2.setOption(option2);

        const floorData3 = []
        data['chart3'].map((item) => {
            floorData3.push({value: Math.round(item.value) || 0, name: item.caption})
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
                    name: 'TEGANGAN',
                    type: 'pie',
                    radius: '50%',
                    data: floorData3,
                    itemStyle: {
                        color: function (param) {
                            return getRandomColor() || '#5470c6';
                        }
                    },
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
        option3 && myChart3.setOption(option3);

        const floorData4 = []
        data['chart4'].map((item) => {
            floorData4.push({value: Number(item.value)?.toFixed(1) || 0, name: item.caption})
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
                    name: 'POWER FACTOR',
                    type: 'pie',
                    radius: '50%',
                    data: floorData4,
                    itemStyle: {
                        color: function (param) {
                            return getRandomColor() || '#5470c6';
                        }
                    },
                    label: {
                        formatter: "{b} : {c|{@d}}",
                        rich: {
                            c: {
                                color: "#4C5058",
                                fontSize: 14,
                                fontWeight: "bold",
                                lineHeight: 33,
                            },
                        },
                    },
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
        option4 && myChart4.setOption(option4);
    })


    setTimeout(() => {
        // window.location.replace(BASE_URL + "show/page4/"+unit);
    }, 15000);
});
