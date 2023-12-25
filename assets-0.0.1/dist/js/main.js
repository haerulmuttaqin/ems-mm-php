const BASE_URL = 'http://' + location.host + '/' + localFolder(location.host);
function localFolder(host) {
    if (host === 'localhost') {
        return 'ems.mm' + '/'
    }
    return ''
}
const APP_VERSION = sessionStorage.getItem("app_version");
const URL = document.location.toString();
const ACCESS_TOKEN = 'pk.eyJ1IjoiaGFlcnVsbXV0dGFxaW4iLCJhIjoiY2oyam1wYjU2MDAwcDJ4bnFtcTNuYjF0cyJ9.dZKKL4w4CwzG4wAeYdTLjA';
// if (sessionStorage.getItem("user_data") === null) {
//     $.ajax({
//         url: BASE_URL + 'auth/get_token/',
//         method: 'post',
//         success: function (data) {
//             let result = JSON.parse(data);
//             if (result.status) {
//                 sessionStorage.setItem("app_version", result.app_data.app_version);
//                 sessionStorage.setItem("app_name", result.app_data.app_name);
//                 sessionStorage.setItem("user_data", JSON.stringify(result.user_data[0]));
//             } else {
//                 toastr.error("User unauthorized! - please login again!" + JSON.stringify(err));
//             }
//         },
//         error: function (err) {
//             toastr.error("User unauthorized! - please login again!" + JSON.stringify(err));
//         }
//     })
// }
const USER_DATA = JSON.parse(sessionStorage.getItem("user_data"));
const ticksStyle = {
    fontColor: '#495057',
    fontStyle: 'bold'
};
const dragTime = 0;
const mode = 'index';
const intersect = true;
const colorArray = ['#ff9856', '#007bff', '#50ff75', '#ff714d', '#00B3E6',
    '#e64cd1', '#3366E6', '#999966', '#99FF99', '#B34D4D',
    '#80B300', '#809900', '#E6B3B3', '#6680B3', '#66991A',
    '#FF99E6', '#CCFF1A', '#FF1A66', '#e68333', '#33FFCC',
    '#66994D', '#B366CC', '#4D8000', '#B33300', '#CC80CC',
    '#66664D', '#991AFF', '#E666FF', '#4DB3FF', '#1AB399',
    '#E666B3', '#33991A', '#CC9999', '#B3B31A', '#00E680',
    '#4D8066', '#809980', '#E6FF80', '#1AFF33', '#999933',
    '#FF3380', '#CCCC00', '#66E64D', '#4D80CC', '#9900B3',
    '#E64D66', '#4DB380', '#FF4D4D', '#99E6E6', '#6666FF'];

const colorDash1 = ['#ff9856', '#007bff'];
const generate = {
    sid: generateSid()
}
function generateSid() {
    return 'xxxxxxxx-xxxx-4xxx-yxxx-xxxxxxxxxxxx'.replace(/[xy]/g, function (c) {
        var r = Math.random() * 16 | 0, v = c == 'x' ? r : (r & 0x3 | 0x8);
        return v.toString(16).toUpperCase();
    });
}
let dataTableExecTime;

function getDaysInMonth() {
    const date = new Date();
    const month = date.getMonth();
    date.setDate(1);
    const allDays = [];
    while (date.getMonth() === month) {
        const d = date.getDate().toString().padStart(2, '0');
        allDays.push(d);
        date.setDate(date.getDate() + 1);
    }
    return allDays
}
function reverseDate(db) {
    let d = new Date(db.split("/").reverse().join("-"));
    let dd = d.getDate();
    let mm = d.getMonth() + 1;
    let yy = d.getFullYear();
    return yy + "-" + mm + "-" + dd;
}
function getYearNow() {
    let d = new Date();
    return d.getFullYear();
}
function getMonthNow() {
    let d = new Date();
    return d.getMonth() + 1;
}
function getDateNow() {
    let d = new Date();
    return d.getDate();
}
/* function showDialogSuccessDeleted() {
    Swal.fire(
        'Deleted!',
        'Your data has been deleted.',
        'success'
    ).then(() => {
        location.reload();
        toastr.success("Data has been deleted!");
    })
} */
function showDialogError(msg) {
    Swal.fire({
        title: 'Failure!',
        html: msg,
        imageUrl: BASE_URL + 'assets-' + APP_VERSION + '/dist/img/undraw_bugsvg.svg'
    })
}
function showDialogSuccess(msg) {
    Swal.fire({
        timer: 1300,
        position: 'center',
        showConfirmButton: false,
        html: '<lottie-player src="' + BASE_URL + 'assets-' + APP_VERSION + '/dist/lottie/success.json"  background="transparent"  speed="2"  style="width: 300px; height: 300px;" autoplay></lottie-player><br>' + msg + '<br>',
    })
}
function showDialogSuccessDeleted(msg) {
    Swal.fire({
        timer: 1300,
        position: 'center',
        showConfirmButton: false,
        html: '<lottie-player src="' + BASE_URL + 'assets-' + APP_VERSION + '/dist/lottie/success_deleted.json"  background="transparent"  speed="2"  style="width: 300px; height: 300px;" autoplay></lottie-player><br>' + msg + '<br>',
    })
}
function showDialogErrorDeleted(mssg) {
    Swal.fire(
        'Failed!',
        'Your data failed to delete.' + mssg,
        'error'
    )
}

function Toast() {
    Swal.fire(
        {
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 2000
        }
    )
}
function redirectOnError(url) {
    popupCenter({ url: url, w: 900, h: 500 });
}
const popupCenter = ({ url, w, h }) => {
    // Fixes dual-screen position                             Most browsers      Firefox
    const dualScreenLeft = window.screenLeft !== undefined ? window.screenLeft : window.screenX;
    const dualScreenTop = window.screenTop !== undefined ? window.screenTop : window.screenY;

    const width = window.innerWidth ? window.innerWidth : document.documentElement.clientWidth ? document.documentElement.clientWidth : screen.width;
    const height = window.innerHeight ? window.innerHeight : document.documentElement.clientHeight ? document.documentElement.clientHeight : screen.height;

    const systemZoom = width / window.screen.availWidth;
    const left = (width - w) / 2 / systemZoom + dualScreenLeft
    const top = (height - h) / 2 / systemZoom + dualScreenTop
    const newWindow = window.open(url,
        '_blank', `
      scrollbars=yes,
      width=${w / systemZoom}, 
      height=${h / systemZoom}, 
      top=${top}, 
      left=${left}
      `
    )

    if (window.focus) newWindow.focus();
}
let alertDelete = {
    title: "Are you sure?",
    text: "Apakah anda yakin menghapus data ini..",
    showCancelButton: true,
    confirmButtonColor: "#dc3545",
    cancelButtonColor: '#7c8a99',
    confirmButtonText: "YES, DELETE",
    cancelButtonText: "CANCEL",
    closeOnConfirm: false,
    closeOnCancel: false,
    allowOutsideClick: false,
    imageUrl: BASE_URL + 'assets-' + APP_VERSION + '/dist/img/undraw_delete.svg'
};
let alertReject = {
    title: "Are you sure?",
    text: "Apakah anda yakin menolak data ini..",
    type: "error",
    showCancelButton: true,
    confirmButtonColor: "#dc3545",
    cancelButtonColor: '#7c8a99',
    confirmButtonText: "YES, REJECT",
    cancelButtonText: "CANCEL",
    closeOnConfirm: false,
    closeOnCancel: false,
    imageSize: '80x80',
    allowOutsideClick: false
};
function timeConversion(millisec) {
    let seconds = (millisec / 1000).toFixed(1);
    let minutes = (millisec / (1000 * 60)).toFixed(1);
    let hours = (millisec / (1000 * 60 * 60)).toFixed(1);
    let days = (millisec / (1000 * 60 * 60 * 24)).toFixed(1);
    if (seconds < 60) {
        return seconds + " sec";
    } else if (minutes < 60) {
        return minutes + " min";
    } else if (hours < 24) {
        return hours + " hours";
    } else {
        return days + " days"
    }
}
function setupSortable() {
    $('.connectedSortable').sortable({
        placeholder: 'sort-highlight',
        connectWith: '.connectedSortable',
        handle: '.card-header, .nav-tabs',
        forcePlaceholderSize: true,
        zIndex: 999999
    })
    $('.connectedSortable .card-header, .connectedSortable .nav-tabs-custom').css('cursor', 'move')
}

function formatRupiah(angka) {
    var number_string = angka.replace(/[^,\d]/g, '').toString(),
        split = number_string.split(','),
        sisa = split[0].length % 3,
        rupiah = split[0].substr(0, sisa),
        ribuan = split[0].substr(sisa).match(/\d{3}/gi);

    // tambahkan titik jika yang di input sudah menjadi angka ribuan
    if (ribuan) {
        let separator = sisa ? '.' : '';
        rupiah += separator + ribuan.join('.');
    }

    rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
    return rupiah;
}
function toTitleCase(str) {
    return str.replace(
        /(\w*\W*|\w*)\s*/g,
        function (txt) {
            return (txt.charAt(0).toUpperCase() + txt.substr(1).toLowerCase())
        }
    );
}

function getRandomColor() {
    var letters = '0123456789ABCDEF';
    var color = '#';
    for (var i = 0; i < 6; i++) {
        color += letters[Math.floor(Math.random() * 16)];
    }
    return color;
}

export {
    BASE_URL,
    APP_VERSION,
    ACCESS_TOKEN,
    URL,
    USER_DATA,
    ticksStyle,
    mode,
    intersect,
    colorArray,
    colorDash1,
    alertDelete,
    showDialogSuccessDeleted,
    showDialogErrorDeleted,
    showDialogError,
    reverseDate,
    getYearNow,
    getMonthNow,
    getDateNow,
    timeConversion,
    dataTableExecTime,
    redirectOnError,
    dragTime,
    setupSortable,
    generateSid,
    Toast,
    showDialogSuccess,
    formatRupiah,
    toTitleCase,
    getDaysInMonth,
    getRandomColor
}


