import {BASE_URL, APP_VERSION, ticksStyle, showDialogError, getRandomColor} from "./main.js";

$(function () {
    "use strict";

    const unit = $('#unit').val()
    const dash = JSON.parse($('#dash').val())
    const timeInterval = dash.find((ref) => ref.ref_name === "TIME_INTERVAL")['ref_value'];

    const chartDom1 = document.getElementById("chart1");
    const chartDom2 = document.getElementById("chart2");
    const chartDom3 = document.getElementById("chart3");
    // const chartDom4 = document.getElementById("chart4");
    const myChart1 = echarts.init(chartDom1);
    const myChart2 = echarts.init(chartDom2);
    const myChart3 = echarts.init(chartDom3);
    // const myChart4 = echarts.init(chartDom4);
    let option1;
    let option2;
    let option3;
    $.get(BASE_URL + "show/page5/chart_data/" + unit, function (result) {
        const data = JSON.parse(result);

        const pieData1 = []
        data['chart1'].map((item) => {
            pieData1.push({value: Number(item.value).toFixed(1) || 0, name: item.caption})
        })
        option1 = {
            tooltip: {
                trigger: "item",
                formatter: "{a} <br/>{b}: {c} ({d}%)",
            },
            series: [
                {
                    name: "DAYA",
                    type: "pie",
                    radius: "50%",
                    label: {
                        formatter: " {a|{b}}{abg|} \n{hr|}\n  {c}  {per|{d}%}  ",
                        backgroundColor: "#F6F8FC",
                        borderColor: "#8C8D8E",
                        borderWidth: 1,
                        borderRadius: 4,
                        rich: {
                            a: {
                                color: "#6E7079",
                                lineHeight: 22,
                                align: "center",
                            },
                            hr: {
                                borderColor: "#8C8D8E",
                                width: "100%",
                                borderWidth: 1,
                                height: 0,
                            },
                            b: {
                                color: "#4C5058",
                                fontSize: 14,
                                fontWeight: "bold",
                                lineHeight: 33,
                            },
                            per: {
                                color: "#fff",
                                backgroundColor: "#4C5058",
                                padding: [3, 4],
                                borderRadius: 4,
                            },
                        },
                    },

                    data: pieData1,
                    emphasis: {
                        itemStyle: {
                            shadowBlur: 10,
                            shadowOffsetX: 0,
                            shadowColor: "rgba(0, 0, 0, 0.5)",
                        },
                    },
                    itemStyle: {
                        color: function (param) {
                            return getRandomColor() || '#5470c6';
                        }
                    },
                },
            ],
        };
        option1 && myChart1.setOption(option1);

        const pieData2 = []
        const legend2 = []
        data['chart2'].map((item) => {
            pieData2.push({value: Number(item.value).toFixed(1) || 0, name: item.caption})
            legend2.push(item.caption)
        })
        option2 = {
            tooltip: {
                trigger: "item",
                formatter: "{a} <br/>{b}: {c} ({d}%)",
            },
            legend: {
                data: legend2,
                show: true,
            },
            series: [
                {
                    name: "DAYA",
                    type: "pie",
                    radius: "50%",
                    labelLine: {
                        length: 30,
                    },
                    label: {
                        formatter: "{a|{b}}{abg|}\n{hr|}\n  {c}  {per|{d}%}  ",
                        backgroundColor: "#F6F8FC",
                        borderColor: "#8C8D8E",
                        borderWidth: 1,
                        borderRadius: 4,
                        rich: {
                            a: {
                                color: "#6E7079",
                                lineHeight: 22,
                                align: "center",
                            },
                            hr: {
                                borderColor: "#8C8D8E",
                                width: "100%",
                                borderWidth: 1,
                                height: 0,
                            },
                            b: {
                                color: "#4C5058",
                                fontSize: 14,
                                fontWeight: "bold",
                                lineHeight: 33,
                            },
                            per: {
                                color: "#fff",
                                backgroundColor: "#4C5058",
                                padding: [3, 4],
                                borderRadius: 4,
                            },
                        },
                    },

                    data: pieData2,
                    emphasis: {
                        itemStyle: {
                            shadowBlur: 10,
                            shadowOffsetX: 0,
                            shadowColor: "rgba(0, 0, 0, 0.5)",
                        },
                    },
                    itemStyle: {
                        color: function (param) {
                            return getRandomColor() || '#5470c6';
                        }
                    },
                },
            ],
        };
        option2 && myChart2.setOption(option2);

        const pieData3 = []
        const legend3 = []
        data['chart3'].map((item) => {
            pieData3.push({value: Number(item.value).toFixed(1) || 0, name: item.caption})
            legend3.push(item.caption)
        })
        option3 = {
            tooltip: {
                trigger: "item",
                formatter: "{a} <br/>{b}: {c} ({d}%)",
            },
            legend: {
                data: legend3,
                show: true,
            },
            series: [
                {
                    name: "DAYA",
                    type: "pie",
                    radius: "50%",
                    labelLine: {
                        length: 30,
                    },
                    label: {
                        formatter: "{a|{b}}{abg|}\n{hr|}\n  {c}  {per|{d}%}  ",
                        backgroundColor: "#F6F8FC",
                        borderColor: "#8C8D8E",
                        borderWidth: 1,
                        borderRadius: 4,
                        rich: {
                            a: {
                                color: "#6E7079",
                                lineHeight: 22,
                                align: "center",
                            },
                            hr: {
                                borderColor: "#8C8D8E",
                                width: "100%",
                                borderWidth: 1,
                                height: 0,
                            },
                            b: {
                                color: "#4C5058",
                                fontSize: 14,
                                fontWeight: "bold",
                                lineHeight: 33,
                            },
                            per: {
                                color: "#fff",
                                backgroundColor: "#4C5058",
                                padding: [3, 4],
                                borderRadius: 4,
                            },
                        },
                    },

                    data: pieData3,
                    emphasis: {
                        itemStyle: {
                            shadowBlur: 10,
                            shadowOffsetX: 0,
                            shadowColor: "rgba(0, 0, 0, 0.5)",
                        },
                    },
                    itemStyle: {
                        color: function (param) {
                            return getRandomColor() || '#5470c6';
                        }
                    },
                },
            ],
        };
        option3 && myChart3.setOption(option3);

    });

    setTimeout(() => {
        window.location.replace(BASE_URL + "show/page6/"+unit);
    }, timeInterval);
});
