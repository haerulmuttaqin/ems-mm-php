import {BASE_URL, APP_VERSION, ticksStyle, showDialogError} from "./main.js";

$(function () {
    "use strict";

    const unit = $('#unit').val()
    const dash = JSON.parse($('#dash').val())
    const timeInterval = dash.find((ref) => ref.ref_name === "TIME_INTERVAL")['ref_value'];

    const chartDom1 = document.getElementById("chart1");
    const chartDom2 = document.getElementById("chart2");
    const myChart1 = echarts.init(chartDom1);
    const myChart2 = echarts.init(chartDom2);

    let option1;
    let option2;
    $.get(BASE_URL + "show/page7/chart_data/" + unit, function (result) {
        const data = JSON.parse(result);
        const pieData = data['used_ratio']
        const chartData = []
        pieData.forEach((item) => {
            chartData.push({value: Number(item?.value).toFixed(1) || 0, name: item?.caption || ""})
        })
        option1 = {
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
                    name: "Rasio Daya Panel Lantai Per Bulan",
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
                    data: chartData,
                },
            ],
        };
        option1 && myChart1.setOption(option1);


        const hours = [
            "00:00",
            "01:00",
            "02:00",
            "03:00",
            "04:00",
            "05:00",
            "06:00",
            "07:00",
            "08:00",
            "09:00",
            "10:00",
            "11:00",
            "12:00",
            "13:00",
            "14:00",
            "15:00",
            "16:00",
            "17:00",
            "18:00",
            "19:00",
            "20:00",
            "21:00",
            "22:00",
            "23:00",
        ]
        const lastDay = []
        const toDay = []
        hours.map((hour) => {
            const itemLast = data['daily_ratio']['lastday'].find((it) => it['hour'] === hour)
            const itemThis = data['daily_ratio']['today'].find((it) => it['hour'] === hour)
            lastDay.push(itemLast || {date_time: hour, value: 0})
            toDay.push(itemThis || {date_time: hour, value: 0})
        })
        option2 = {
            xAxis: {
                type: "category",
                axisLabel: {
                    interval: 0,
                    rotate: 90
                },
                data: hours,
            },
            yAxis: {
                type: "value",
            },
            legend: {
                show: true,
                data: ['Last Day', 'Today']
            },
            series: [
                {
                    name: 'Last Day',
                    data: lastDay,
                    type: "bar",
                },
                {
                    name: 'Today',
                    data: toDay,
                    type: "bar",
                },
            ],
        };

        option2 && myChart2.setOption(option2);
    });


    setTimeout(() => {
        window.location.replace(BASE_URL + "show/page1/"+unit);
    }, timeInterval);
});
