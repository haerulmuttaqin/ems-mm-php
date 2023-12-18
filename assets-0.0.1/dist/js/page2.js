import { BASE_URL, APP_VERSION, ticksStyle, showDialogError } from "./main.js";
console.log("page 1");

$(function () {
  "use strict";


 

  setTimeout(() => {
    window.location.replace(BASE_URL + "pages/page1");
  }, 5000);
});
