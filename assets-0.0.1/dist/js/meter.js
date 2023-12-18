import { BASE_URL, USER_DATA, generateSid, showDialogError, timeConversion, setupSortable, Toast, showDialogSuccess } from "./main.js";
setupSortable()
$(function () {
    'use strict'
    let isHide = true
    let timeExcecution
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
        pageLength: 50,
        initComplete: function (settings, json) {
            $('#table-data-record_length').find('select').addClass('select2');
            $('#table-data-record_length').find('label').addClass('d-block');
            $('#table-data-record_length').find('select').removeClass('form-control-sm').addClass('form-control');
            $('#table-data-record_length').replaceAll($('#lenght'));
            $('#table-data-record_filter').find('input').removeClass('form-control-sm').addClass("from-control");
            $('#table-data-record_filter').find('input').attr('placeholder', 'Search');
            $('#table-data-record_filter').removeClass('mt-2');
            $('#table-data-record_filter').find('input').addClass('mt-sm-0');
            $('#table-data-record_filter').find('input').replaceAll($('#search'));
            $('#table-data-record_wrapper').find("div").slice(1, 4).remove();
            $('.form-group').css("margin-bottom", 'unset');
            $('.form-group').css("margin-bottom", '8px');
            $(".dataTables_length .select2").select2({minimumResultsForSearch: -1});
            $(".dataTables_length .select2").css('font-weight', 'normal');
            $('#table-data-record_info').replaceAll($('#info'));
            $('.shimmer').fadeOut(100);
        },
        order: [],
        bStateSave: true,
        stateDuration: -1,
        ajax: {
            url: BASE_URL + "meter/data/",
            type: "POST",
            data: function (d) {
                d.group = $('#s_group').val();
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
                window.location.href = BASE_URL + 'meter/item/' + data[6]
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

    initFilterSelectOptionGroup($('#s_group'), null);

    $('#refresh-table').click(function() {
        refreshTable();
    })

    $('#filter').click(function () {
        $('.hidable').slideToggle(50);
        updateFilterState();
        
    });

    $('#collexp').click(function () {
        $('.hidable').slideToggle(50);
        updateFilterState();
    });

    function updateFilterState() {
        if (isHide) {
            $('#collexp').find('i').removeClass("fas fa-caret-down");
            $('#collexp').find('i').addClass("fas fa-caret-up");
            $('#filter').html('<i class="cil-vertical-align-top mr-1"></i> Hide Filter');
            isHide = false
        } else {
            $('#filter').html('<i class="cil-filter mr-1"></i> Advanced Filter');
            $('#collexp').find('i').removeClass("fas fa-caret-up");
            $('#collexp').find('i').addClass("fas fa-caret-down");
            isHide = true;
        }
    }

    function initFilterSelectOptionGroup(id, value) {
        $.getJSON(BASE_URL + 'master/get_meter_group/' + value, function (result) {
            result.forEach(function (data) {
                if (value == data.meter_group) {
                    $(id).append('<option selected value="' + data.meter_group + '">' + data.meter_group + '</option>')
                } else {
                    $(id).append('<option value="' + data.meter_group + '">' + data.meter_group + '</option>')
                }
            });
            if (result.length > 0) {    
                $(id).select2({
                    minimumResultsForSearch: -1
                });
                $(id).change(function (e) {
                    refreshTable();
                    e.preventDefault();
                });
            }
        });
    }

    function refreshTable() {
        recordTable.page(0);
        recordTable.ajax.reload(null, false);
    }

});