import { BASE_URL } from "./main.js";

$(function () {
  "use strict";

  var pages = [
    function page1() {
      // $("#content").load(BASE_URL + "/pages/page1");
      window.location.replace(BASE_URL + "pages/page1");
    },
    function page2() {
      // $("#content").load(BASE_URL + "/pages/page2");
      window.location.replace(BASE_URL + "pages/page2");
    },
  ];

  function nextHeadline(index) {
    pages[index]();
    window.setTimeout(
      nextHeadline.bind(undefined, (index + 1) % pages.length),
      5000
    );
  }

  nextHeadline(0);
});
