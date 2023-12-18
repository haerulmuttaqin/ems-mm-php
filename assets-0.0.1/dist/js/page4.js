import {BASE_URL, APP_VERSION, ticksStyle, showDialogError} from "./main.js";

$(function () {
    "use strict";

    const chartDom1 = document.getElementById("chart1");
    const chartDom2 = document.getElementById("chart2");
    const chartDom3 = document.getElementById("chart3");
    const chartDom4 = document.getElementById("chart4");
    const myChart1 = echarts.init(chartDom1);
    const myChart2 = echarts.init(chartDom2);
    const myChart3 = echarts.init(chartDom3);
    const myChart4 = echarts.init(chartDom4);
    let option;
    let option2;
    $.get(BASE_URL + 'pages/page1/pie_data', function (result) {

        const data = JSON.parse(result)

        option = {
            dataset: {
                source: [
                    ['score', 'amount', 'product'],
                    [89.3, 58212, 'Lantai 1'],
                    [57.1, 78254, 'Lantai 2'],
                    [74.4, 41032, 'Lantai 3'],
                    [50.1, 12755, 'Lantai 4'],
                    [89.7, 20145, 'Lantai 5'],
                    [68.1, 79146, 'Lantai 6'],
                    [19.6, 91852, 'Lantai 7'],
                    [10.6, 102852, 'Lantai 8'],
                    [10.6, 101352, 'Lantai 9'],
                    [10.6, 104852, 'Lantai 10'],
                    [10.6, 101752, 'Lantai 11'],
                    [10.6, 11852, 'Lantai 12'],
                    [10.6, 101852, 'Lantai 13'],
                    [10.6, 12852, 'Lantai 14'],
                    [10.6, 106852, 'Lantai 15'],
                    [10.6, 21852, 'Lantai 16'],
                    [10.6, 51852, 'Lantai 17'],
                    [10.6, 71852, 'Lantai 18'],
                    [10.6, 10159, 'Lantai 19'],
                ]
            },
            grid: { containLabel: true },
            xAxis: { name: 'amount' },
            yAxis: { type: 'category' },
            visualMap: {
                orient: 'horizontal',
                left: 'center',
                // min: 10,
                // max: 1000,
                text: ['High Score', 'Low Score'],
                // Map the score column to color
                dimension: 0,
                inRange: {
                    color: ['#65B581', '#3485ff', '#2615b9', '#FD665F', '#5fd8fd', '#65B581', '#3485ff', '#2615b9', '#FD665F', '#5fd8fd']
                }
            },
            series: [
                {
                    type: 'bar',
                    encode: {
                        // Map the "amount" column to X axis.
                        x: 'amount',
                        // Map the "product" column to Y axis
                        y: 'product'
                    }
                }
            ]
        };

        option && myChart1.setOption(option);


        option2 = {
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
                        { value: 1048, name: 'Lantai 1' },
                        { value: 735, name: 'Lantai 2' },
                        { value: 580, name: 'Lantai 3' },
                        { value: 484, name: 'Lantai 4' },
                        { value: 300, name: 'Lantai 5' }
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
        option2 && myChart2.setOption(option2);
        option2 && myChart3.setOption(option2);
        option2 && myChart4.setOption(option2);
    })


    setTimeout(() => {
        window.location.replace(BASE_URL + "pages/page5");
    }, 5000);
});
