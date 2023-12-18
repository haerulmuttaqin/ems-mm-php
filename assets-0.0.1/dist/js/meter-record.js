import { BASE_URL, USER_DATA, Toast, showDialogError, timeConversion, setupSortable, getMonthNow, getYearNow, toTitleCase } from "./main.js";
setupSortable()
$(function () {
    'use strict'
    let isHide = true
    let timeExcecution
    let filter_date = moment(new Date()).format('YYYY-MM-DD HH:mm:ss');
    let cardHeaderHeight = $('.card-header').height()
    let cardFooterHeight = $('.card-header').height()
    let navbarHeight = $('.navbar').height()
    let footerHeight = $('footer').height()
    let recordTable = $('#table-data-record').DataTable({
        processing: true,
        serverSide: true,
        scrollY: (document.documentElement.clientHeight - cardHeaderHeight) - (navbarHeight - footerHeight) - cardFooterHeight - 158,
        scrollX: true,
        scrollCollapse: true,
        searcing: false,
        pageLength: 50,
        initComplete: function (settings, json) {
            $('#table-data-record_length').find('select').addClass('select2');
            $('#table-data-record_length').find('label').addClass('d-block');
            $('#table-data-record_length').find('select').removeClass('form-control-sm').addClass('form-control');
            $('#table-data-record_length').replaceAll($('#lenght'));
            $('#table-data-record_wrapper').find("div").slice(1, 4).remove();
            $('.form-group').css("margin-bottom", 'unset');
            $('.form-group').css("margin-bottom", '8px');
            $(".dataTables_length .select2").select2({ minimumResultsForSearch: -1 });
            $(".dataTables_length .select2").css('font-weight', 'normal');
            $('#table-data-record_info').replaceAll($('#info'));
            $('.shimmer').fadeOut(100);
        },
        order: [],
        bStateSave: true,
        stateDuration: -1,
        ajax: {
            url: BASE_URL + "record/data/",
            type: "POST",
            data: function (d) {
                d.filter_mode = $('#s_type').find(':selected').val() == null ? 0 : $('#s_type').find(':selected').val();
                d.filter_date = filter_date;
                d.meter_sid = $('#s_meter').val();
            },
            error: function (err) {
                showDialogError(err.statusText);
            },
            beforeSend: function () {
                let newDate = new Date();
                timeExcecution = newDate.getTime();
            }
        },
        drawCallback: function () {
            let endDate = new Date();
            let dataTableExecTime = timeConversion(endDate.getTime() - timeExcecution);
            let info = $('.dataTables_info').text();
            $('.dataTables_info').html(info + '<span class="text-gray"> (' + dataTableExecTime + ')</span>');
            $('#table-data-record_paginate').css('display', '');
            $('#table-data-record_paginate').replaceAll($('#page'));
        },
        rowCallback: function (row, data, index) {
            $(row).find('.condition').addClass('bg-cond-' + data[16])
        },
        columnDefs: [
            {
                targets: 0,
                orderable: false,
            }
        ],
        createdRow: function (row, data, index) {
            $(row).addClass('changeItem');
            $(row).addClass('grab');
            $(row).css('cursor', 'pointer');
            $(row).click(function () {
                $(this).addClass('selected').siblings().removeClass("selected");
                // window.location.href = BASE_URL + 'meter/item/' + data[5]
            });
        }
    });
    $('#table-data-record tbody').addClass('member');
    $(".dataTables_scrollBody").scroll(function () {
        if ($(".dataTables_scrollBody").scrollTop() > 0) {
            $('.dataTables_scrollHead').addClass('border-bottom-line');
            $('.DTFC_LeftHeadWrapper').addClass('border-bottom-line');
        } else {
            $('.dataTables_scrollHead').removeClass('border-bottom-line');
            $('.DTFC_LeftHeadWrapper').removeClass('border-bottom-line');
        }
    });

    initFilterSelectOptionMeter($('#s_meter'), null);
    initFilterSelectOption($('#s_type'), 'FILTER TYPE', null);
    initDateFilter();
    initDateFilterMonthYear();
    // initFilterMonth($('#s_month'))
    initFilterYear($('#s_year'))

    $('#refresh-table').click(function () {
        refreshTable();
    })

    $('#filter').click(function () {
        refreshTable();
    });

    function initFilterSelectOptionMeter(id, value) {
        $.getJSON(BASE_URL + 'master/get_meter/' + value, function (result) {
            result.forEach(function (data) {
                if (value == data.meter_sid) {
                    $(id).append('<option selected value="' + data.meter_sid + '">' + data.meter_name + '</option>')
                } else {
                    $(id).append('<option value="' + data.meter_sid + '">' + data.meter_name + '</option>')
                }
            });
        });
    }

    function initFilterSelectOption(id, type, value) {
        $.getJSON(BASE_URL + 'master/ref_generic/' + type, function (result) {
            result.forEach(function (data) {
                if (value == data.ref_value) {
                    $(id).append('<option selected value="' + data.ref_value + '">' + toTitleCase(data.ref_name) + '</option>')
                } else {
                    $(id).append('<option value="' + data.ref_value + '">' + toTitleCase(data.ref_name) + '</option>')
                }
            });
            $(id).select2({
                minimumResultsForSearch: -1
            });
            $(id).change(function (e) {
                updateMode($(this).find(':selected').val());
                e.preventDefault();
            });
        }).done(function () {
            updateMode(0);
        });
    }

    function initDateFilter() {
        $('#report_filter').val(moment(filter_date).format('DD MMM YYYY'));
        $('#report_filter').daterangepicker({
            singleDatePicker: true,
            showDropdowns: true,
            timePicker: false,
            range: false,
            autoUpdateInput: false,
            opens: 'left',
            locale: {
                format: 'DD-MM-YYYY',
                cancelLabel: 'Clear'
            },
            startDate: moment(filter_date).format('DD-MM-YYYY HH:mm')
        });
        $('#report_filter').on('apply.daterangepicker', function (ev, picker) {
            $(this).val(picker.startDate.format('DD MMM YYYY'));
            filter_date = picker.startDate.format('YYYY-MM-DD HH:mm:ss');
        });
        $('#report_filter').on('cancel.daterangepicker', function (ev, picker) {
            $(this).val('');
        });
    }

    function initDateFilterMonthYear() {
        $('#s_month').val(moment(filter_date).format('MMM YYYY'));
        $('#s_month').daterangepicker({
            singleDatePicker: true,
            showDropdowns: true,
            timePicker: false,
            range: false,
            autoUpdateInput: false,
            opens: 'left',
            locale: {
                format: 'MM-YYYY',
                cancelLabel: 'Clear'
            },
            startDate: moment(filter_date).format('MM-YYYY')
        });
        $('#s_month').on('showCalendar.daterangepicker', (ev, picker) => {
            $('.table-condensed thead tr:nth-child(2), .table-condensed tbody').hide();
            $('.table-condensed').css('width', '250px');
            var start = moment((parseInt($('.left .monthselect').val()) + 1) + '/01/' + $('.left .yearselect').val())
            var end = moment((parseInt($('.right .monthselect').val()) + 1) + '/01/' + $('.right .yearselect').val())
            $('#s_month').data('daterangepicker').setStartDate(start);
            $('#s_month').data('daterangepicker').setEndDate(end);
        })
        $('#s_month').on('hide.daterangepicker', function (ev, picker) {
            $('.table-condensed tbody tr:nth-child(2) td').click();
            $(this).val(picker.startDate.format('MMM YYYY'));
            filter_date = picker.startDate.format('YYYY-MM-DD HH:mm:ss');
        });
        $('#s_month').on('cancel.daterangepicker', function (ev, picker) {
            $(this).val('');
        });

    }

    function initFilterMonth(id) {
        $.getJSON(BASE_URL + 'master/get_month/', function (result) {
            result.forEach(function (data) {
                if (getMonthNow() === parseInt(data.val)) {
                    $(id).append('<option selected value="' + data.val + '">' + data.name + '</option>')
                } else {
                    $(id).append('<option value="' + data.val + '">' + data.name + '</option>')
                }
            })
            $(id).select2({
                minimumResultsForSearch: -1
            })
            $(id).change(function (e) {
                filter_date = $(this).find(':selected').val()
                e.preventDefault();
            });
        })
    }

    function initFilterYear(id) {
        $.getJSON(BASE_URL + 'master/get_year/', function (result) {
            result.forEach(function (data) {
                if (getYearNow() === parseInt(data.val)) {
                    $(id).append('<option selected value="' + data.val + '">' + data.val + '</option>')
                } else {
                    $(id).append('<option value="' + data.val + '">' + data.val + '</option>')
                }
            })
            $(id).select2({
                minimumResultsForSearch: -1
            })
            $(id).change(function (e) {
                filter_date = replaceYear($(this).find(':selected').val())
                e.preventDefault();
            });
        })
    }

    $('#daily-mode').hide()
    $('#monthly-mode').hide()
    function updateMode(mode) {
        initDateFilter();
        initDateFilterMonthYear();
        if (mode == 0) {
            $('#hourly-mode').show()
            $('#daily-mode').hide()
            $('#monthly-mode').hide()
            $('#filter-mode-label').text('HOURS')
        }
        else if (mode == 1) {
            $('#hourly-mode').hide()
            $('#daily-mode').show()
            $('#monthly-mode').hide()
            $('#filter-mode-label').text('DAYS')
        }
        else if (mode == 2) {
            $('#hourly-mode').hide()
            $('#daily-mode').hide()
            $('#monthly-mode').show()
            $('#filter-mode-label').text('MONTHS')
            filter_date = replaceYear($('#s_year').val());
        }
        else {
            $('#hourly-mode').hide()
            $('#daily-mode').hide()
            $('#monthly-mode').hide()
            $('#filter-mode-label').text('YEARS')
        }
    }

    function refreshTable() {
        if ($('#s_meter').val() === null) {
            toastr.error('Kwh not selected!')
        } else {
            recordTable.page(0);
            recordTable.ajax.reload(null, false);
        }
    }

    function replaceYear(year) {
        let dateObj = new Date(filter_date);
        let month = dateObj.getUTCMonth() + 1;
        let day = dateObj.getUTCDate();
        let newdate = year + "-" + month + "-" + day;
        return newdate;
    } 

});