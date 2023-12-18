import { BASE_URL } from "./main.js";
$(document).ready(function () {
    setTimeout(function () {
        $("#username").val('');
        $("#username").attr('placeholder', 'Username');
        $("#password").val('');
        $("#password").attr('placeholder', 'Password');
    }, 500);
    setTimeout(function () {
        $('.transaction-body').removeClass('loading-mask-round');
    }, 500);
});

$(function () {
    login(BASE_URL);
});

function login(baseUrl) {

    let loginBtn = $('#login');
    $('.transaction-body').addClass('loading-mask-round');
    loginBtn.text('....');

    let lon = 0.0;
    let lat = 0.0;
    let device = null;

    if ("geolocation" in navigator) {
        navigator.geolocation.getCurrentPosition(function (position) {
            lon = position.coords.longitude;
            lat = position.coords.latitude;
        });
    }

    let nVer = navigator.appVersion;
    let nAgt = navigator.userAgent;
    let browserName = navigator.appName;
    let fullVersion = '' + parseFloat(navigator.appVersion);
    let majorVersion = parseInt(navigator.appVersion, 10);
    let nameOffset, verOffset, ix;

    // In Opera, the true version is after "Opera" or after "Version"
    if ((verOffset = nAgt.indexOf("Opera")) != -1) {
        browserName = "Opera";
        fullVersion = nAgt.substring(verOffset + 6);
        if ((verOffset = nAgt.indexOf("Version")) != -1)
            fullVersion = nAgt.substring(verOffset + 8);
    }
    // In MSIE, the true version is after "MSIE" in userAgent
    else if ((verOffset = nAgt.indexOf("MSIE")) != -1) {
        browserName = "Microsoft Internet Explorer";
        fullVersion = nAgt.substring(verOffset + 5);
    }
    // In Chrome, the true version is after "Chrome"
    else if ((verOffset = nAgt.indexOf("Chrome")) != -1) {
        browserName = "Chrome";
        fullVersion = nAgt.substring(verOffset + 7);
    }
    // In Safari, the true version is after "Safari" or after "Version"
    else if ((verOffset = nAgt.indexOf("Safari")) != -1) {
        browserName = "Safari";
        fullVersion = nAgt.substring(verOffset + 7);
        if ((verOffset = nAgt.indexOf("Version")) != -1)
            fullVersion = nAgt.substring(verOffset + 8);
    }
    // In Firefox, the true version is after "Firefox"
    else if ((verOffset = nAgt.indexOf("Firefox")) != -1) {
        browserName = "Firefox";
        fullVersion = nAgt.substring(verOffset + 8);
    }
    // In most other browsers, "name/version" is at the end of userAgent
    else if ((nameOffset = nAgt.lastIndexOf(' ') + 1) <
        (verOffset = nAgt.lastIndexOf('/'))) {
        browserName = nAgt.substring(nameOffset, verOffset);
        fullVersion = nAgt.substring(verOffset + 1);
        if (browserName.toLowerCase() == browserName.toUpperCase()) {
            browserName = navigator.appName;
        }
    }
    // trim the fullVersion string at semicolon/space if present
    if ((ix = fullVersion.indexOf(";")) != -1)
        fullVersion = fullVersion.substring(0, ix);
    if ((ix = fullVersion.indexOf(" ")) != -1)
        fullVersion = fullVersion.substring(0, ix);

    majorVersion = parseInt('' + fullVersion, 10);
    if (isNaN(majorVersion)) {
        fullVersion = '' + parseFloat(navigator.appVersion);
    }

    let OSName = "Unknown OS";
    if (navigator.appVersion.indexOf("Win") != -1) OSName = "Windows";
    if (navigator.appVersion.indexOf("Mac") != -1) OSName = "MacOS";
    if (navigator.appVersion.indexOf("X11") != -1) OSName = "UNIX";
    if (navigator.appVersion.indexOf("Linux") != -1) OSName = "Linux";
    console.log(navigator.appVersion);

    $.getJSON('https://ipapi.co/json/', function (data) {
        device = {
            brand: 'Browser: ' + browserName,
            model: fullVersion,
            release: OSName + ' IP Address: ' + data.ip,
            version_app: 'Web Base'
        };
    });

    loginBtn.fadeIn();
    loginBtn.removeAttr('disabled');
    loginBtn.text('LOGIN');

    $('#login').click(function () {
        processLogin();
    })

    $('#password').keyup(function (event) {
        if (event.keyCode === 13) {
            // Cancel the default action, if needed
            event.preventDefault();
            // Trigger the button element with a click
            document.getElementById("login").click();
          }
    })

    function processLogin() {
        $('.transaction-body').addClass('loading-mask-round');
        loginBtn.text('....');
        let user = $('#username').val();
        let pass = $('#password').val();

        setTimeout(function () {

            if (user == '') {
                $('#username').addClass('is-invalid')
                $('#username').keyup(function () {
                    $('#username').removeClass('is-invalid');
                });
                toastr.error("Username can't be empty!");
                $('#login').text('LOGIN');
                $('.transaction-body').removeClass('loading-mask-round');
            } else if (pass == '') {
                $('#password').addClass('is-invalid');
                $('#password').keyup(function () {
                    $('#password').removeClass('is-invalid');
                });
                toastr.error("Password can't be empty!");
                $('#login').text('LOGIN');
                $('.transaction-body').removeClass('loading-mask-round');
            }

            $.ajax({
                url: baseUrl + 'auth/login/',
                data: {
                    username: user,
                    password: pass,
                    lon: lon,
                    lat: lat,
                    device: JSON.stringify(device),
                },
                method: 'post',
                success: function (data) {
                    let result = JSON.parse(data);
                    if (result.status) {
                        sessionStorage.setItem("app_version", result.app_data.app_version);
                        sessionStorage.setItem("app_name", result.app_data.app_name);
                        sessionStorage.setItem("user_data", JSON.stringify(result.user_data[0]));
                        // sessionStorage.setItem("current_menu", '24FDB81A-B5F9-4326-A09B-7135C90D6C48');
                        toastr.success("Login Succesfully!");
                        window.location.href = baseUrl + 'dashboard/'
                    } else {
                        toastr.error("Login Failed! " + result.message);
                        $('#login').text('LOGIN');
                        $('#username').addClass('is-invalid')
                        $('#username').keyup(function () {
                            $('#username').removeClass('is-invalid');
                        });
                        $('#password').addClass('is-invalid');
                        $('#password').keyup(function () {
                            $('#password').removeClass('is-invalid');
                        });
                        $('.transaction-body').removeClass('loading-mask-round');
                    }
                },
                error: function (err) {
                    toastr.error("Login failed " + err.responseText);
                    $('#login').text('LOGIN');
                    $('.transaction-body').removeClass('loading-mask-round');
                }
            })

        }, 100);
    }
}