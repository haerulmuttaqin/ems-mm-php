import { BASE_URL, APP_VERSION, ticksStyle, showDialogError } from "./main.js";
console.log("page 1");

$(function () {
  "use strict";


  console.log("page 1");


  const chartDom = document.getElementById("main");
  const myChart = echarts.init(chartDom);
  let option;

  option = {
    tooltip: {
      trigger: "item",
      formatter: "{a} <br/>{b}: {c} ({d}%)",
    },
    legend: {
      data: [
        "Direct",
        "Marketing",
        "Search Engine",
        "Email",
        "Union Ads",
        "Video Ads",
        "Baidu",
        "Google",
        "Bing",
        "Others",
      ],
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
        data: [
          { value: 1048, name: "PM LIFT" },
          { value: 335, name: "PM STOP KONTAK" },
          { value: 310, name: "PM AC/AHU" },
          { value: 251, name: "PM PENERANGAN" },
        ],
      },
    ],
  };

  option && myChart.setOption(option);


  setTimeout(() => {
    window.location.replace(BASE_URL + "pages/page2");
  }, 5000);
});
