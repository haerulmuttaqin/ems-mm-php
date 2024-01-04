import {BASE_URL, APP_VERSION, ticksStyle, showDialogError} from "./main.js";

$(function () {
    "use strict";

    const unit = $('#unit').val()

    const chartDom = document.getElementById("main");
    const myChart = echarts.init(chartDom);
    let option;
    $.get(BASE_URL + 'show/page1/pie_data/' + unit, function (result) {

        const data = JSON.parse(result)
        const chartData = []
        data.forEach((item) => {
            chartData.push({value: Math.round(item?.value) || 0, name: item?.caption || ""})
        })
        option = {
            tooltip: {
                trigger: "item",
                formatter: "{a} <br/>{b}: {c} ({d}%)",
            },
            legend: {
                data: [],
                show: false,
            },
            series: [
                {
                    name: "Rasio Daya Panel Per Bulan",
                    type: "pie",
                    radius: '50%',
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
                    data: chartData,
                },
            ],
        };

        option && myChart.setOption(option);
    })


    setTimeout(() => {
        window.location.replace(BASE_URL + "show/page2/"+unit);
    }, 15000);
});
